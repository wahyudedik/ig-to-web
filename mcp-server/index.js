#!/usr/bin/env node

import { Server } from '@modelcontextprotocol/sdk/server/index.js';
import { StdioServerTransport } from '@modelcontextprotocol/sdk/server/stdio.js';
import {
  CallToolRequestSchema,
  ListToolsRequestSchema,
  ListResourcesRequestSchema,
  ReadResourceRequestSchema,
} from '@modelcontextprotocol/sdk/types.js';
import { readFile, readdir, stat } from 'fs/promises';
import { join, resolve, relative } from 'path';
import { exec } from 'child_process';
import { promisify } from 'util';

const execAsync = promisify(exec);

// Project root directory
const PROJECT_ROOT = resolve(process.cwd(), '..');

// Server instance
const server = new Server(
  {
    name: 'ig-to-web-mcp-server',
    version: '1.0.0',
  },
  {
    capabilities: {
      tools: {},
      resources: {},
    },
  }
);

// Helper function to get file content
async function getFileContent(filePath) {
  try {
    const fullPath = resolve(PROJECT_ROOT, filePath);
    const content = await readFile(fullPath, 'utf-8');
    return content;
  } catch (error) {
    throw new Error(`Failed to read file: ${error.message}`);
  }
}

// Helper function to list directory
async function listDirectory(dirPath) {
  try {
    const fullPath = resolve(PROJECT_ROOT, dirPath);
    const items = await readdir(fullPath, { withFileTypes: true });
    return items.map(item => ({
      name: item.name,
      type: item.isDirectory() ? 'directory' : 'file',
      path: join(dirPath, item.name),
    }));
  } catch (error) {
    throw new Error(`Failed to list directory: ${error.message}`);
  }
}

// Helper function to execute artisan commands
async function runArtisanCommand(command) {
  try {
    const { stdout, stderr } = await execAsync(`php artisan ${command}`, {
      cwd: PROJECT_ROOT,
      maxBuffer: 1024 * 1024 * 10, // 10MB buffer
    });
    return { stdout, stderr };
  } catch (error) {
    throw new Error(`Artisan command failed: ${error.message}`);
  }
}

// Helper function to search files
async function searchInFiles(searchTerm, directory = '.') {
  const results = [];

  async function searchDir(dir) {
    try {
      const fullPath = resolve(PROJECT_ROOT, dir);
      const items = await readdir(fullPath, { withFileTypes: true });

      for (const item of items) {
        const itemPath = join(dir, item.name);

        // Skip certain directories
        if (item.isDirectory()) {
          if (['node_modules', 'vendor', 'storage', '.git'].includes(item.name)) {
            continue;
          }
          await searchDir(itemPath);
        } else if (item.isFile()) {
          // Only search in text files
          if (item.name.match(/\.(php|js|css|html|blade\.php|json|md|txt)$/)) {
            try {
              const content = await getFileContent(itemPath);
              if (content.toLowerCase().includes(searchTerm.toLowerCase())) {
                const lines = content.split('\n');
                const matches = lines
                  .map((line, index) => ({ line: line, number: index + 1 }))
                  .filter(({ line }) => line.toLowerCase().includes(searchTerm.toLowerCase()))
                  .slice(0, 3); // Limit to first 3 matches per file

                results.push({
                  file: itemPath,
                  matches: matches,
                });
              }
            } catch (err) {
              // Skip files that can't be read
            }
          }
        }
      }
    } catch (err) {
      // Skip directories that can't be accessed
    }
  }

  await searchDir(directory);
  return results;
}

// List available tools
server.setRequestHandler(ListToolsRequestSchema, async () => {
  return {
    tools: [
      {
        name: 'read_file',
        description: 'Read the contents of a file in the Laravel project',
        inputSchema: {
          type: 'object',
          properties: {
            path: {
              type: 'string',
              description: 'Relative path to the file from project root',
            },
          },
          required: ['path'],
        },
      },
      {
        name: 'list_directory',
        description: 'List contents of a directory in the Laravel project',
        inputSchema: {
          type: 'object',
          properties: {
            path: {
              type: 'string',
              description: 'Relative path to the directory from project root (default: ".")',
              default: '.',
            },
          },
        },
      },
      {
        name: 'artisan_command',
        description: 'Execute a Laravel Artisan command',
        inputSchema: {
          type: 'object',
          properties: {
            command: {
              type: 'string',
              description: 'Artisan command to execute (without "php artisan" prefix)',
            },
          },
          required: ['command'],
        },
      },
      {
        name: 'search_files',
        description: 'Search for a term across project files',
        inputSchema: {
          type: 'object',
          properties: {
            term: {
              type: 'string',
              description: 'Search term to look for',
            },
            directory: {
              type: 'string',
              description: 'Directory to search in (default: ".")',
              default: '.',
            },
          },
          required: ['term'],
        },
      },
      {
        name: 'get_routes',
        description: 'Get all Laravel routes',
        inputSchema: {
          type: 'object',
          properties: {},
        },
      },
      {
        name: 'get_models',
        description: 'List all Eloquent models',
        inputSchema: {
          type: 'object',
          properties: {},
        },
      },
      {
        name: 'get_controllers',
        description: 'List all controllers',
        inputSchema: {
          type: 'object',
          properties: {},
        },
      },
      {
        name: 'db_query',
        description: 'Execute a database query using Laravel DB facade',
        inputSchema: {
          type: 'object',
          properties: {
            query: {
              type: 'string',
              description: 'SQL query to execute (SELECT only for safety)',
            },
          },
          required: ['query'],
        },
      },
      {
        name: 'db_table',
        description: 'Get all data from a specific table',
        inputSchema: {
          type: 'object',
          properties: {
            table: {
              type: 'string',
              description: 'Table name',
            },
            limit: {
              type: 'number',
              description: 'Limit number of rows (default: 100)',
              default: 100,
            },
          },
          required: ['table'],
        },
      },
      {
        name: 'read_logs',
        description: 'Read Laravel log file',
        inputSchema: {
          type: 'object',
          properties: {
            lines: {
              type: 'number',
              description: 'Number of lines to read from the end (default: 50)',
              default: 50,
            },
            date: {
              type: 'string',
              description: 'Log date (YYYY-MM-DD). If not provided, reads today\'s log',
            },
          },
        },
      },
      {
        name: 'tinker',
        description: 'Execute PHP code using Laravel Tinker',
        inputSchema: {
          type: 'object',
          properties: {
            code: {
              type: 'string',
              description: 'PHP code to execute (without <?php tag)',
            },
          },
          required: ['code'],
        },
      },
      {
        name: 'read_env',
        description: 'Read Laravel .env file configuration',
        inputSchema: {
          type: 'object',
          properties: {
            mask_sensitive: {
              type: 'boolean',
              description: 'Mask sensitive values like passwords, API keys (default: true)',
              default: true,
            },
          },
        },
      },
    ],
  };
});

// Handle tool calls
server.setRequestHandler(CallToolRequestSchema, async (request) => {
  const { name, arguments: args } = request.params;

  try {
    switch (name) {
      case 'read_file': {
        const content = await getFileContent(args.path);
        return {
          content: [
            {
              type: 'text',
              text: content,
            },
          ],
        };
      }

      case 'list_directory': {
        const items = await listDirectory(args.path || '.');
        return {
          content: [
            {
              type: 'text',
              text: JSON.stringify(items, null, 2),
            },
          ],
        };
      }

      case 'artisan_command': {
        const result = await runArtisanCommand(args.command);
        return {
          content: [
            {
              type: 'text',
              text: `STDOUT:\n${result.stdout}\n\nSTDERR:\n${result.stderr}`,
            },
          ],
        };
      }

      case 'search_files': {
        const results = await searchInFiles(args.term, args.directory || '.');
        return {
          content: [
            {
              type: 'text',
              text: JSON.stringify(results, null, 2),
            },
          ],
        };
      }

      case 'get_routes': {
        const result = await runArtisanCommand('route:list --json');
        return {
          content: [
            {
              type: 'text',
              text: result.stdout,
            },
          ],
        };
      }

      case 'get_models': {
        const items = await listDirectory('app/Models');
        const models = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        return {
          content: [
            {
              type: 'text',
              text: JSON.stringify(models, null, 2),
            },
          ],
        };
      }

      case 'get_controllers': {
        const items = await listDirectory('app/Http/Controllers');
        const controllers = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        return {
          content: [
            {
              type: 'text',
              text: JSON.stringify(controllers, null, 2),
            },
          ],
        };
      }

      case 'db_query': {
        // Use artisan tinker to execute query safely
        const sanitizedQuery = args.query.trim();

        // Only allow SELECT queries for safety
        if (!sanitizedQuery.toLowerCase().startsWith('select')) {
          throw new Error('Only SELECT queries are allowed for safety. Use tinker tool for other operations.');
        }

        const code = `DB::select("${sanitizedQuery.replace(/"/g, '\\"')}");`;
        const result = await runArtisanCommand(`tinker --execute="${code}"`);
        return {
          content: [
            {
              type: 'text',
              text: result.stdout || result.stderr,
            },
          ],
        };
      }

      case 'db_table': {
        const table = args.table;
        const limit = args.limit || 100;
        const code = `DB::table('${table}')->limit(${limit})->get();`;
        const result = await runArtisanCommand(`tinker --execute="${code}"`);
        return {
          content: [
            {
              type: 'text',
              text: result.stdout || result.stderr,
            },
          ],
        };
      }

      case 'read_logs': {
        const lines = args.lines || 50;
        const date = args.date || new Date().toISOString().split('T')[0];
        const logFile = `storage/logs/laravel-${date}.log`;

        try {
          const content = await getFileContent(logFile);
          const logLines = content.split('\n');
          const lastLines = logLines.slice(-lines).join('\n');
          return {
            content: [
              {
                type: 'text',
                text: `=== Last ${lines} lines of ${logFile} ===\n\n${lastLines}`,
              },
            ],
          };
        } catch (error) {
          return {
            content: [
              {
                type: 'text',
                text: `Log file not found: ${logFile}\nError: ${error.message}`,
              },
            ],
          };
        }
      }

      case 'tinker': {
        const code = args.code;
        const result = await runArtisanCommand(`tinker --execute="${code}"`);
        return {
          content: [
            {
              type: 'text',
              text: `=== Tinker Output ===\n${result.stdout}\n\n=== Stderr ===\n${result.stderr}`,
            },
          ],
        };
      }

      case 'read_env': {
        try {
          const content = await getFileContent('.env');
          const maskSensitive = args.mask_sensitive !== false; // default true

          const sensitiveKeys = [
            'PASSWORD', 'SECRET', 'KEY', 'TOKEN', 'API',
            'PRIVATE', 'CREDENTIAL', 'ACCESS', 'AUTH'
          ];

          let processedContent = content;

          if (maskSensitive) {
            const lines = content.split('\n');
            const processedLines = lines.map(line => {
              // Skip comments and empty lines
              if (line.trim().startsWith('#') || line.trim() === '') {
                return line;
              }

              // Check if line contains sensitive key
              const isSensitive = sensitiveKeys.some(key =>
                line.toUpperCase().includes(key + '=')
              );

              if (isSensitive) {
                const [key, ...valueParts] = line.split('=');
                if (valueParts.length > 0) {
                  const value = valueParts.join('=');
                  // Mask the value but show first 2 chars if exists
                  const maskedValue = value.length > 2
                    ? value.substring(0, 2) + '********'
                    : '********';
                  return `${key}=${maskedValue}`;
                }
              }

              return line;
            });
            processedContent = processedLines.join('\n');
          }

          return {
            content: [
              {
                type: 'text',
                text: `=== Laravel .env Configuration ===\n` +
                  `Mask Sensitive: ${maskSensitive ? 'Yes' : 'No'}\n\n` +
                  processedContent,
              },
            ],
          };
        } catch (error) {
          return {
            content: [
              {
                type: 'text',
                text: `.env file not found or cannot be read\nError: ${error.message}`,
              },
            ],
          };
        }
      }

      default:
        throw new Error(`Unknown tool: ${name}`);
    }
  } catch (error) {
    return {
      content: [
        {
          type: 'text',
          text: `Error: ${error.message}`,
        },
      ],
      isError: true,
    };
  }
});

// List available resources
server.setRequestHandler(ListResourcesRequestSchema, async () => {
  return {
    resources: [
      {
        uri: 'laravel://config',
        name: 'Laravel Configuration',
        description: 'Access to Laravel configuration files',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://routes',
        name: 'Laravel Routes',
        description: 'All registered routes in the application',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://models',
        name: 'Eloquent Models',
        description: 'List of all Eloquent models',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://migrations',
        name: 'Database Migrations',
        description: 'All database migration files',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://seeders',
        name: 'Database Seeders',
        description: 'All database seeder files',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://middleware',
        name: 'HTTP Middleware',
        description: 'All middleware classes',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://policies',
        name: 'Authorization Policies',
        description: 'All policy files for authorization',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://requests',
        name: 'Form Requests',
        description: 'All form request validation classes',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://controllers',
        name: 'HTTP Controllers',
        description: 'All controller files',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://services',
        name: 'Service Classes',
        description: 'All service layer classes',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://factories',
        name: 'Model Factories',
        description: 'All model factory files',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://tests',
        name: 'Test Files',
        description: 'All PHPUnit test files',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://views',
        name: 'Blade Views',
        description: 'Blade template structure overview',
        mimeType: 'application/json',
      },
      {
        uri: 'laravel://env-example',
        name: 'Environment Example',
        description: 'Environment configuration template',
        mimeType: 'text/plain',
      },
    ],
  };
});

// Read resources
server.setRequestHandler(ReadResourceRequestSchema, async (request) => {
  const { uri } = request.params;

  try {
    switch (uri) {
      case 'laravel://config': {
        const configFiles = await listDirectory('config');
        const configs = {};
        for (const file of configFiles.filter(f => f.type === 'file')) {
          const content = await getFileContent(file.path);
          configs[file.name] = content;
        }
        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(configs, null, 2),
            },
          ],
        };
      }

      case 'laravel://routes': {
        const result = await runArtisanCommand('route:list --json');
        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: result.stdout,
            },
          ],
        };
      }

      case 'laravel://models': {
        const items = await listDirectory('app/Models');
        const models = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const modelDetails = {};

        for (const model of models) {
          const content = await getFileContent(model.path);
          modelDetails[model.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(modelDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://migrations': {
        const items = await listDirectory('database/migrations');
        const migrations = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const migrationDetails = {};

        for (const migration of migrations) {
          const content = await getFileContent(migration.path);
          migrationDetails[migration.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(migrationDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://seeders': {
        const items = await listDirectory('database/seeders');
        const seeders = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const seederDetails = {};

        for (const seeder of seeders) {
          const content = await getFileContent(seeder.path);
          seederDetails[seeder.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(seederDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://middleware': {
        const items = await listDirectory('app/Http/Middleware');
        const middleware = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const middlewareDetails = {};

        for (const mw of middleware) {
          const content = await getFileContent(mw.path);
          middlewareDetails[mw.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(middlewareDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://policies': {
        const items = await listDirectory('app/Policies');
        const policies = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const policyDetails = {};

        for (const policy of policies) {
          const content = await getFileContent(policy.path);
          policyDetails[policy.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(policyDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://requests': {
        const items = await listDirectory('app/Http/Requests');
        const requests = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const requestDetails = {};

        for (const request of requests) {
          const content = await getFileContent(request.path);
          requestDetails[request.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(requestDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://controllers': {
        const items = await listDirectory('app/Http/Controllers');
        const controllers = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const controllerDetails = {};

        for (const controller of controllers) {
          const content = await getFileContent(controller.path);
          controllerDetails[controller.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(controllerDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://services': {
        try {
          const items = await listDirectory('app/Services');
          const services = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
          const serviceDetails = {};

          for (const service of services) {
            const content = await getFileContent(service.path);
            serviceDetails[service.name] = content;
          }

          return {
            contents: [
              {
                uri,
                mimeType: 'application/json',
                text: JSON.stringify(serviceDetails, null, 2),
              },
            ],
          };
        } catch (error) {
          return {
            contents: [
              {
                uri,
                mimeType: 'application/json',
                text: JSON.stringify({ message: 'Services directory not found or empty' }, null, 2),
              },
            ],
          };
        }
      }

      case 'laravel://factories': {
        const items = await listDirectory('database/factories');
        const factories = items.filter(item => item.type === 'file' && item.name.endsWith('.php'));
        const factoryDetails = {};

        for (const factory of factories) {
          const content = await getFileContent(factory.path);
          factoryDetails[factory.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(factoryDetails, null, 2),
            },
          ],
        };
      }

      case 'laravel://tests': {
        const featureTests = await listDirectory('tests/Feature');
        const unitTests = await listDirectory('tests/Unit');
        const allTests = {};

        allTests.feature = {};
        for (const test of featureTests.filter(item => item.type === 'file' && item.name.endsWith('.php'))) {
          const content = await getFileContent(test.path);
          allTests.feature[test.name] = content;
        }

        allTests.unit = {};
        for (const test of unitTests.filter(item => item.type === 'file' && item.name.endsWith('.php'))) {
          const content = await getFileContent(test.path);
          allTests.unit[test.name] = content;
        }

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(allTests, null, 2),
            },
          ],
        };
      }

      case 'laravel://views': {
        async function getViewStructure(dir, basePath = '') {
          const items = await listDirectory(dir);
          const structure = {};

          for (const item of items) {
            if (item.type === 'directory') {
              structure[item.name] = await getViewStructure(item.path, `${basePath}${item.name}/`);
            } else if (item.name.endsWith('.blade.php')) {
              structure[item.name] = {
                path: item.path,
                viewName: `${basePath}${item.name.replace('.blade.php', '')}`
              };
            }
          }

          return structure;
        }

        const viewStructure = await getViewStructure('resources/views');

        return {
          contents: [
            {
              uri,
              mimeType: 'application/json',
              text: JSON.stringify(viewStructure, null, 2),
            },
          ],
        };
      }

      case 'laravel://env-example': {
        try {
          const content = await getFileContent('.env.example');
          return {
            contents: [
              {
                uri,
                mimeType: 'text/plain',
                text: content,
              },
            ],
          };
        } catch (error) {
          return {
            contents: [
              {
                uri,
                mimeType: 'text/plain',
                text: '.env.example file not found',
              },
            ],
          };
        }
      }

      default:
        throw new Error(`Unknown resource: ${uri}`);
    }
  } catch (error) {
    throw new Error(`Failed to read resource: ${error.message}`);
  }
});

// Start the server
async function main() {
  const transport = new StdioServerTransport();
  await server.connect(transport);
  console.error('IG-to-Web MCP Server running on stdio');
}

main().catch((error) => {
  console.error('Server error:', error);
  process.exit(1);
});

