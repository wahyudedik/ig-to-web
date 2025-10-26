#!/usr/bin/env node

/**
 * IG-to-Web MCP Server v3.0 - ULTIMATE EDITION
 * 
 * 🎨 Code Generators (5 tools):
 * - Model, Controller, Migration, Request, Policy Generator
 * 
 * 📊 Database Schema Tools (3 tools):
 * - Schema Visualizer, Relationship Analyzer, Missing Index Finder
 * 
 * 🌿 Git Integration (4 tools):
 * - Status, Log, Branches, Diff
 * 
 * 🔍 Advanced Analysis (8 tools):
 * - Bug Detection, Security Scanner, N+1 Detector, Performance Profiler
 * - Dead Code Analyzer, Code Quality Metrics, Blade Validator
 * 
 * 📦 Full Laravel Resources (14 resources):
 * - Complete project exploration & documentation
 * 
 * Total: 31 Tools + 14 Resources = Ultimate Laravel Development Assistant
 */

import { Server } from '@modelcontextprotocol/sdk/server/index.js';
import { StdioServerTransport } from '@modelcontextprotocol/sdk/server/stdio.js';
import {
    CallToolRequestSchema,
    ListToolsRequestSchema,
    ListResourcesRequestSchema,
    ReadResourceRequestSchema,
} from '@modelcontextprotocol/sdk/types.js';
import { readFile, readdir, stat, access } from 'fs/promises';
import { join, resolve, relative, extname } from 'path';
import { exec } from 'child_process';
import { promisify } from 'util';

const execAsync = promisify(exec);
const PROJECT_ROOT = resolve(process.cwd(), '..');

// ============================================
// SERVER SETUP
// ============================================

const server = new Server(
    {
        name: 'ig-to-web-mcp-server-v2',
        version: '2.0.0',
    },
    {
        capabilities: {
            tools: {},
            resources: {},
        },
    }
);

// ============================================
// HELPER FUNCTIONS
// ============================================

async function getFileContent(filePath) {
    try {
        const fullPath = resolve(PROJECT_ROOT, filePath);
        const content = await readFile(fullPath, 'utf-8');
        return content;
    } catch (error) {
        throw new Error(`Failed to read file: ${error.message}`);
    }
}

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

async function runArtisanCommand(command) {
    try {
        const { stdout, stderr } = await execAsync(`php artisan ${command}`, {
            cwd: PROJECT_ROOT,
            maxBuffer: 1024 * 1024 * 10,
        });
        return { stdout, stderr };
    } catch (error) {
        throw new Error(`Artisan command failed: ${error.message}`);
    }
}

async function searchInFiles(searchTerm, directory = '.') {
    const results = [];

    async function searchDir(dir) {
        try {
            const fullPath = resolve(PROJECT_ROOT, dir);
            const items = await readdir(fullPath, { withFileTypes: true });

            for (const item of items) {
                const itemPath = join(dir, item.name);

                if (item.isDirectory()) {
                    if (['node_modules', 'vendor', 'storage', '.git'].includes(item.name)) {
                        continue;
                    }
                    await searchDir(itemPath);
                } else if (item.isFile()) {
                    if (item.name.match(/\.(php|js|css|html|blade\.php|json|md|txt)$/)) {
                        try {
                            const content = await getFileContent(itemPath);
                            if (content.toLowerCase().includes(searchTerm.toLowerCase())) {
                                const lines = content.split('\n');
                                const matches = lines
                                    .map((line, index) => ({ line: line, number: index + 1 }))
                                    .filter(({ line }) => line.toLowerCase().includes(searchTerm.toLowerCase()))
                                    .slice(0, 3);

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

// ============================================
// ADVANCED BUG DETECTION FUNCTIONS
// ============================================

/**
 * Detect Blade Template Errors
 */
async function detectBladeErrors(filePath = 'resources/views') {
    const errors = [];

    async function checkBladeFile(file) {
        try {
            const content = await getFileContent(file);
            const lines = content.split('\n');

            lines.forEach((line, index) => {
                const lineNum = index + 1;

                // Check for common Blade errors
                const checks = [
                    {
                        pattern: /@\{\{/g,
                        message: 'Mixed @ and {{ syntax (should be @{{ or {{ }})',
                        severity: 'error'
                    },
                    {
                        pattern: /\{\{\s*\$[a-zA-Z_]\w*\s*-\s*>\s*[a-zA-Z_]\w*\s*\}\}/g,
                        message: 'Spacing issue in {{ $var - > prop }} (should be {{ $var->prop }})',
                        severity: 'error'
                    },
                    {
                        pattern: /@if\s*\([^)]*\)\s*$/g,
                        message: '@if without @endif',
                        severity: 'warning'
                    },
                    {
                        pattern: /@foreach\s*\([^)]*\)\s*$/g,
                        message: '@foreach without @endforeach',
                        severity: 'warning'
                    },
                    {
                        pattern: /\{\{.*\$.*undefined/gi,
                        message: 'Possible undefined variable reference',
                        severity: 'error'
                    },
                    {
                        pattern: /<script>.*\{\{/g,
                        message: 'Blade syntax inside <script> tag (use @json or escape)',
                        severity: 'warning'
                    },
                    {
                        pattern: /\{\{\s*\$[a-zA-Z_]\w*\s*\}\}\s*\?\?/g,
                        message: 'Null coalescing after Blade echo (use {{ $var ?? default }})',
                        severity: 'info'
                    },
                ];

                checks.forEach(check => {
                    if (check.pattern.test(line)) {
                        errors.push({
                            file: file,
                            line: lineNum,
                            code: line.trim(),
                            message: check.message,
                            severity: check.severity,
                            type: 'blade'
                        });
                    }
                });
            });

            // Check for unmatched directives
            const directivePairs = [
                { open: '@if', close: '@endif' },
                { open: '@foreach', close: '@endforeach' },
                { open: '@for', close: '@endfor' },
                { open: '@while', close: '@endwhile' },
                { open: '@section', close: '@endsection' },
                { open: '@push', close: '@endpush' },
            ];

            directivePairs.forEach(pair => {
                const openCount = (content.match(new RegExp(pair.open, 'g')) || []).length;
                const closeCount = (content.match(new RegExp(pair.close, 'g')) || []).length;

                if (openCount !== closeCount) {
                    errors.push({
                        file: file,
                        line: 0,
                        code: '',
                        message: `Unmatched ${pair.open}/${pair.close} (${openCount} open, ${closeCount} close)`,
                        severity: 'error',
                        type: 'blade'
                    });
                }
            });

        } catch (err) {
            // Skip files that can't be read
        }
    }

    async function scanDir(dir) {
        try {
            const items = await listDirectory(dir);
            for (const item of items) {
                if (item.type === 'directory') {
                    await scanDir(item.path);
                } else if (item.name.endsWith('.blade.php')) {
                    await checkBladeFile(item.path);
                }
            }
        } catch (err) {
            // Skip directories that can't be accessed
        }
    }

    await scanDir(filePath);
    return errors;
}

/**
 * Detect PHP Backend Errors
 */
async function detectPHPErrors(directory = 'app') {
    const errors = [];

    async function checkPHPFile(file) {
        try {
            const content = await getFileContent(file);
            const lines = content.split('\n');

            lines.forEach((line, index) => {
                const lineNum = index + 1;

                const checks = [
                    {
                        pattern: /\$[a-zA-Z_]\w*\s*->\s*[a-zA-Z_]\w*.*\;\s*$/g,
                        message: 'Possible undefined property access (missing null check)',
                        severity: 'warning'
                    },
                    {
                        pattern: /DB::raw\(/g,
                        message: 'Using DB::raw() - potential SQL injection risk',
                        severity: 'error'
                    },
                    {
                        pattern: /\$_GET\[|    \$_POST\[|\$_REQUEST\[/g,
                        message: 'Direct superglobal access - use request() instead',
                        severity: 'warning'
                    },
                    {
                        pattern: /eval\(/g,
                        message: 'Using eval() - security risk',
                        severity: 'error'
                    },
                    {
                        pattern: /extract\(/g,
                        message: 'Using extract() - security risk',
                        severity: 'error'
                    },
                    {
                        pattern: /->get\(\)\s*->\s*count\(\)/g,
                        message: 'Inefficient query: use ->count() instead of ->get()->count()',
                        severity: 'warning'
                    },
                    {
                        pattern: /foreach.*->get\(\)/g,
                        message: 'Potential N+1 query in foreach',
                        severity: 'warning'
                    },
                    {
                        pattern: /dd\(|dump\(/g,
                        message: 'Debug function left in code',
                        severity: 'info'
                    },
                ];

                checks.forEach(check => {
                    if (check.pattern.test(line)) {
                        errors.push({
                            file: file,
                            line: lineNum,
                            code: line.trim(),
                            message: check.message,
                            severity: check.severity,
                            type: 'php'
                        });
                    }
                });
            });

            // Check for syntax errors
            try {
                const { stderr } = await execAsync(`php -l "${resolve(PROJECT_ROOT, file)}"`, {
                    cwd: PROJECT_ROOT
                });
                if (stderr) {
                    errors.push({
                        file: file,
                        line: 0,
                        code: '',
                        message: `PHP Syntax Error: ${stderr}`,
                        severity: 'error',
                        type: 'php'
                    });
                }
            } catch (err) {
                errors.push({
                    file: file,
                    line: 0,
                    code: '',
                    message: `PHP Syntax Error: ${err.message}`,
                    severity: 'error',
                    type: 'php'
                });
            }

        } catch (err) {
            // Skip files that can't be read
        }
    }

    async function scanDir(dir) {
        try {
            const items = await listDirectory(dir);
            for (const item of items) {
                if (item.type === 'directory') {
                    await scanDir(item.path);
                } else if (item.name.endsWith('.php')) {
                    await checkPHPFile(item.path);
                }
            }
        } catch (err) {
            // Skip directories that can't be accessed
        }
    }

    await scanDir(directory);
    return errors;
}

/**
 * Detect N+1 Query Problems
 */
async function detectN1Queries(directory = 'app/Http/Controllers') {
    const issues = [];

    async function checkFile(file) {
        try {
            const content = await getFileContent(file);
            const lines = content.split('\n');

            let inForeach = false;
            let foreachStart = 0;

            lines.forEach((line, index) => {
                const lineNum = index + 1;

                // Detect foreach loops
                if (line.match(/foreach\s*\(/)) {
                    inForeach = true;
                    foreachStart = lineNum;
                }

                if (inForeach) {
                    // Detect potential N+1 queries inside foreach
                    if (line.match(/\$[a-zA-Z_]\w*\s*->\s*(hasMany|belongsTo|hasOne|belongsToMany|morphMany)/)) {
                        issues.push({
                            file: file,
                            line: lineNum,
                            foreachLine: foreachStart,
                            code: line.trim(),
                            message: 'Potential N+1 query: relationship access inside foreach',
                            severity: 'warning',
                            suggestion: 'Use eager loading: Model::with(\'relationship\')->get()'
                        });
                    }

                    // Detect direct Model::find inside foreach
                    if (line.match(/[A-Z][a-zA-Z0-9_]+::find\(/)) {
                        issues.push({
                            file: file,
                            line: lineNum,
                            foreachLine: foreachStart,
                            code: line.trim(),
                            message: 'Potential N+1 query: Model::find() inside foreach',
                            severity: 'error',
                            suggestion: 'Load all IDs at once: Model::whereIn(\'id\', $ids)->get()'
                        });
                    }
                }

                // Exit foreach
                if (line.match(/\}\s*$/)) {
                    inForeach = false;
                }
            });

            // Check for missing with() on relationship queries
            const relationshipPattern = /->(hasMany|belongsTo|hasOne|belongsToMany)\s*\(\)/g;
            const withPattern = /->with\(/g;

            if (relationshipPattern.test(content) && !withPattern.test(content)) {
                issues.push({
                    file: file,
                    line: 0,
                    code: '',
                    message: 'File has relationships but no eager loading detected',
                    severity: 'info',
                    suggestion: 'Consider using eager loading with with() method'
                });
            }

        } catch (err) {
            // Skip files that can't be read
        }
    }

    async function scanDir(dir) {
        try {
            const items = await listDirectory(dir);
            for (const item of items) {
                if (item.type === 'directory') {
                    await scanDir(item.path);
                } else if (item.name.endsWith('.php')) {
                    await checkFile(item.path);
                }
            }
        } catch (err) {
            // Skip
        }
    }

    await scanDir(directory);
    return issues;
}

/**
 * Security Vulnerability Scanner
 */
async function scanSecurityVulnerabilities(directory = 'app') {
    const vulnerabilities = [];

    async function checkFile(file) {
        try {
            const content = await getFileContent(file);
            const lines = content.split('\n');

            lines.forEach((line, index) => {
                const lineNum = index + 1;

                const securityChecks = [
                    {
                        pattern: /password.*=.*['"][^'"]*['"]/gi,
                        message: 'Hardcoded password detected',
                        severity: 'critical',
                        cwe: 'CWE-798'
                    },
                    {
                        pattern: /api[_-]?key.*=.*['"][^'"]{20,}['"]/gi,
                        message: 'Hardcoded API key detected',
                        severity: 'critical',
                        cwe: 'CWE-798'
                    },
                    {
                        pattern: /\$_GET\[.*\].*\$_POST\[.*\]/g,
                        message: 'Unvalidated user input',
                        severity: 'high',
                        cwe: 'CWE-20'
                    },
                    {
                        pattern: /exec\(|shell_exec\(|system\(|passthru\(/g,
                        message: 'Command injection risk',
                        severity: 'critical',
                        cwe: 'CWE-78'
                    },
                    {
                        pattern: /unserialize\(/g,
                        message: 'Object injection risk',
                        severity: 'high',
                        cwe: 'CWE-502'
                    },
                    {
                        pattern: /md5\(|sha1\(/g,
                        message: 'Weak hashing algorithm',
                        severity: 'medium',
                        cwe: 'CWE-327'
                    },
                    {
                        pattern: /file_get_contents\(\s*\$_/g,
                        message: 'Local file inclusion risk',
                        severity: 'high',
                        cwe: 'CWE-98'
                    },
                ];

                securityChecks.forEach(check => {
                    if (check.pattern.test(line)) {
                        vulnerabilities.push({
                            file: file,
                            line: lineNum,
                            code: line.trim().substring(0, 100),
                            message: check.message,
                            severity: check.severity,
                            cwe: check.cwe,
                            type: 'security'
                        });
                    }
                });
            });
        } catch (err) {
            // Skip
        }
    }

    async function scanDir(dir) {
        try {
            const items = await listDirectory(dir);
            for (const item of items) {
                if (item.type === 'directory') {
                    await scanDir(item.path);
                } else if (item.name.endsWith('.php')) {
                    await checkFile(item.path);
                }
            }
        } catch (err) {
            // Skip
        }
    }

    await scanDir(directory);
    return vulnerabilities;
}

/**
 * Dead Code Analyzer
 */
async function analyzeDeadCode(directory = 'app') {
    const deadCode = {
        unusedMethods: [],
        unusedVariables: [],
        unusedImports: [],
    };

    // Get all PHP files
    const allFiles = [];

    async function collectFiles(dir) {
        try {
            const items = await listDirectory(dir);
            for (const item of items) {
                if (item.type === 'directory') {
                    await collectFiles(item.path);
                } else if (item.name.endsWith('.php')) {
                    allFiles.push(item.path);
                }
            }
        } catch (err) {
            // Skip
        }
    }

    await collectFiles(directory);

    // Analyze each file
    for (const file of allFiles) {
        try {
            const content = await getFileContent(file);

            // Find method definitions
            const methodPattern = /(public|protected|private)\s+function\s+([a-zA-Z_]\w*)\s*\(/g;
            let match;

            while ((match = methodPattern.exec(content)) !== null) {
                const methodName = match[2];

                // Skip magic methods and common Laravel methods
                const skipMethods = ['__construct', '__destruct', 'boot', 'register', 'handle', 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];
                if (skipMethods.includes(methodName)) continue;

                // Search for method usage in all files
                let usageCount = 0;
                for (const searchFile of allFiles) {
                    if (searchFile === file) continue;

                    const searchContent = await getFileContent(searchFile);
                    const usagePattern = new RegExp(`->${methodName}\\(|::${methodName}\\(`, 'g');
                    const matches = searchContent.match(usagePattern);
                    if (matches) usageCount += matches.length;
                }

                if (usageCount === 0) {
                    deadCode.unusedMethods.push({
                        file: file,
                        method: methodName,
                        visibility: match[1],
                        message: `Method ${methodName}() appears to be unused`
                    });
                }
            }

            // Find unused imports
            const importPattern = /use\s+([A-Za-z\\]+)(\s+as\s+([A-Za-z]+))?;/g;
            while ((match = importPattern.exec(content)) !== null) {
                const importClass = match[3] || match[1].split('\\').pop();
                const usagePattern = new RegExp(`\\b${importClass}\\b`, 'g');
                const matches = content.match(usagePattern);

                // If only found once (the import itself), it's unused
                if (!matches || matches.length <= 1) {
                    deadCode.unusedImports.push({
                        file: file,
                        import: match[1],
                        alias: match[3] || null,
                        message: `Import ${match[1]} appears to be unused`
                    });
                }
            }

        } catch (err) {
            // Skip
        }
    }

    return deadCode;
}

/**
 * Code Quality Metrics
 */
async function analyzeCodeQuality(filePath) {
    try {
        const content = await getFileContent(filePath);
        const lines = content.split('\n');

        const metrics = {
            file: filePath,
            totalLines: lines.length,
            codeLines: 0,
            commentLines: 0,
            blankLines: 0,
            complexity: 0,
            functions: 0,
            classes: 0,
            issues: [],
        };

        let inComment = false;
        let functionComplexity = 0;

        lines.forEach((line, index) => {
            const trimmed = line.trim();

            // Count blank lines
            if (!trimmed) {
                metrics.blankLines++;
                return;
            }

            // Count comment lines
            if (trimmed.startsWith('//') || trimmed.startsWith('#') || trimmed.startsWith('*')) {
                metrics.commentLines++;
                return;
            }

            if (trimmed.startsWith('/*')) inComment = true;
            if (inComment) {
                metrics.commentLines++;
                if (trimmed.endsWith('*/')) inComment = false;
                return;
            }

            // Count code lines
            metrics.codeLines++;

            // Count functions
            if (trimmed.match(/function\s+/)) {
                metrics.functions++;
            }

            // Count classes
            if (trimmed.match(/^class\s+/)) {
                metrics.classes++;
            }

            // Calculate complexity
            const complexityKeywords = ['if', 'else', 'elseif', 'for', 'foreach', 'while', 'case', 'catch', '&&', '||'];
            complexityKeywords.forEach(keyword => {
                if (trimmed.includes(keyword)) {
                    metrics.complexity++;
                    functionComplexity++;
                }
            });

            // Check for code smells
            if (line.length > 120) {
                metrics.issues.push({
                    line: index + 1,
                    message: 'Line too long (> 120 characters)',
                    severity: 'info'
                });
            }

            if (functionComplexity > 10) {
                metrics.issues.push({
                    line: index + 1,
                    message: 'Function complexity too high (> 10)',
                    severity: 'warning'
                });
            }

            // Detect deep nesting
            const indentation = line.match(/^\s*/)[0].length;
            if (indentation > 20) {
                metrics.issues.push({
                    line: index + 1,
                    message: 'Deep nesting detected (> 5 levels)',
                    severity: 'warning'
                });
            }
        });

        // Calculate maintainability index (simplified)
        metrics.maintainabilityIndex = Math.max(0, 100 - metrics.complexity - (metrics.codeLines / 10));
        metrics.commentRatio = (metrics.commentLines / metrics.codeLines * 100).toFixed(2);

        return metrics;
    } catch (err) {
        throw new Error(`Failed to analyze code quality: ${err.message}`);
    }
}

/**
 * Performance Profiler
 */
async function profilePerformance(directory = 'app/Http/Controllers') {
    const issues = [];

    async function checkFile(file) {
        try {
            const content = await getFileContent(file);
            const lines = content.split('\n');

            lines.forEach((line, index) => {
                const lineNum = index + 1;

                const performanceChecks = [
                    {
                        pattern: /->all\(\)/g,
                        message: 'Using ->all() loads all records into memory',
                        severity: 'warning',
                        suggestion: 'Use ->get() with limit or pagination'
                    },
                    {
                        pattern: /->get\(\)\s*->\s*count\(\)/g,
                        message: 'Inefficient count: loads all records then counts',
                        severity: 'error',
                        suggestion: 'Use ->count() directly'
                    },
                    {
                        pattern: /foreach.*->get\(\)/g,
                        message: 'Query inside loop causes performance issues',
                        severity: 'error',
                        suggestion: 'Move query outside loop or use eager loading'
                    },
                    {
                        pattern: /Cache::remember.*function\(\)/g,
                        message: 'Good: Using cache',
                        severity: 'positive',
                        suggestion: null
                    },
                    {
                        pattern: /->chunk\(/g,
                        message: 'Good: Using chunk for large datasets',
                        severity: 'positive',
                        suggestion: null
                    },
                ];

                performanceChecks.forEach(check => {
                    if (check.pattern.test(line)) {
                        issues.push({
                            file: file,
                            line: lineNum,
                            code: line.trim().substring(0, 80),
                            message: check.message,
                            severity: check.severity,
                            suggestion: check.suggestion,
                            type: 'performance'
                        });
                    }
                });
            });
        } catch (err) {
            // Skip
        }
    }

    async function scanDir(dir) {
        try {
            const items = await listDirectory(dir);
            for (const item of items) {
                if (item.type === 'directory') {
                    await scanDir(item.path);
                } else if (item.name.endsWith('.php')) {
                    await checkFile(item.path);
                }
            }
        } catch (err) {
            // Skip
        }
    }

    await scanDir(directory);
    return issues;
}

/**
 * Auto-fix Suggestions Generator
 */
function generateAutoFix(error) {
    const fixes = {
        'Mixed @ and {{ syntax': {
            pattern: /@\{\{/g,
            replacement: '{{',
            explanation: 'Remove @ before {{ for proper Blade syntax'
        },
        'Spacing issue in {{ $var - > prop }}': {
            pattern: /\{\{\s*\$([a-zA-Z_]\w*)\s*-\s*>\s*([a-zA-Z_]\w*)\s*\}\}/g,
            replacement: '{{ $$$1->$2 }}',
            explanation: 'Fix spacing in object property access'
        },
        'Using DB::raw()': {
            pattern: /DB::raw\((.*)\)/g,
            replacement: '/* TODO: Sanitize input */ DB::raw($1)',
            explanation: 'Add sanitization comment for security review'
        },
        'Direct superglobal access': {
            pattern: /\$_GET\['([^']+)'\]/g,
            replacement: 'request()->input(\'$1\')',
            explanation: 'Use Laravel request helper for safer input handling'
        },
        'Debug function left in code': {
            pattern: /(dd|dump)\(/g,
            replacement: '// $1(',
            explanation: 'Comment out debug function'
        },
    };

    for (const [key, fix] of Object.entries(fixes)) {
        if (error.message.includes(key)) {
            return fix;
        }
    }

    return null;
}

// ============================================
// TOOL HANDLERS
// ============================================

server.setRequestHandler(ListToolsRequestSchema, async () => {
    return {
        tools: [
            // ============================================
            // ORIGINAL TOOLS
            // ============================================
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

            // ============================================
            // CODE GENERATOR TOOLS
            // ============================================
            {
                name: 'generate_model',
                description: '🎨 Generate Laravel Model with optional migration, factory, and seeder',
                inputSchema: {
                    type: 'object',
                    properties: {
                        name: {
                            type: 'string',
                            description: 'Model name (e.g., Post, UserProfile)',
                        },
                        with_migration: {
                            type: 'boolean',
                            description: 'Generate migration file (default: true)',
                            default: true,
                        },
                        with_factory: {
                            type: 'boolean',
                            description: 'Generate factory file (default: false)',
                            default: false,
                        },
                        with_seeder: {
                            type: 'boolean',
                            description: 'Generate seeder file (default: false)',
                            default: false,
                        },
                    },
                    required: ['name'],
                },
            },
            {
                name: 'generate_controller',
                description: '🎨 Generate Laravel Controller with optional CRUD methods',
                inputSchema: {
                    type: 'object',
                    properties: {
                        name: {
                            type: 'string',
                            description: 'Controller name (e.g., PostController)',
                        },
                        resource: {
                            type: 'boolean',
                            description: 'Generate resource controller with CRUD methods (default: false)',
                            default: false,
                        },
                        api: {
                            type: 'boolean',
                            description: 'Generate API controller (default: false)',
                            default: false,
                        },
                    },
                    required: ['name'],
                },
            },
            {
                name: 'generate_migration',
                description: '🎨 Generate database migration file',
                inputSchema: {
                    type: 'object',
                    properties: {
                        name: {
                            type: 'string',
                            description: 'Migration name (e.g., create_posts_table)',
                        },
                        table: {
                            type: 'string',
                            description: 'Table name (optional)',
                        },
                    },
                    required: ['name'],
                },
            },
            {
                name: 'generate_request',
                description: '🎨 Generate Form Request validation class',
                inputSchema: {
                    type: 'object',
                    properties: {
                        name: {
                            type: 'string',
                            description: 'Request name (e.g., StorePostRequest)',
                        },
                    },
                    required: ['name'],
                },
            },
            {
                name: 'generate_policy',
                description: '🎨 Generate authorization Policy class',
                inputSchema: {
                    type: 'object',
                    properties: {
                        name: {
                            type: 'string',
                            description: 'Policy name (e.g., PostPolicy)',
                        },
                        model: {
                            type: 'string',
                            description: 'Model name (optional)',
                        },
                    },
                    required: ['name'],
                },
            },

            // ============================================
            // DATABASE SCHEMA TOOLS
            // ============================================
            {
                name: 'show_database_schema',
                description: '📊 Show complete database schema with tables, columns, and types',
                inputSchema: {
                    type: 'object',
                    properties: {
                        table: {
                            type: 'string',
                            description: 'Specific table name (optional, shows all if not provided)',
                        },
                    },
                },
            },
            {
                name: 'analyze_relationships',
                description: '📊 Analyze model relationships and foreign keys',
                inputSchema: {
                    type: 'object',
                    properties: {
                        model: {
                            type: 'string',
                            description: 'Specific model name (optional)',
                        },
                    },
                },
            },
            {
                name: 'find_missing_indexes',
                description: '📊 Find columns that should have indexes but don\'t',
                inputSchema: {
                    type: 'object',
                    properties: {},
                },
            },

            // ============================================
            // GIT INTEGRATION TOOLS
            // ============================================
            {
                name: 'git_status',
                description: '🌿 Get Git repository status',
                inputSchema: {
                    type: 'object',
                    properties: {},
                },
            },
            {
                name: 'git_log',
                description: '🌿 Get Git commit history',
                inputSchema: {
                    type: 'object',
                    properties: {
                        limit: {
                            type: 'number',
                            description: 'Number of commits to show (default: 10)',
                            default: 10,
                        },
                    },
                },
            },
            {
                name: 'git_branches',
                description: '🌿 List all Git branches',
                inputSchema: {
                    type: 'object',
                    properties: {},
                },
            },
            {
                name: 'git_diff',
                description: '🌿 Show Git diff for changes',
                inputSchema: {
                    type: 'object',
                    properties: {
                        file: {
                            type: 'string',
                            description: 'Specific file path (optional)',
                        },
                        staged: {
                            type: 'boolean',
                            description: 'Show staged changes (default: false)',
                            default: false,
                        },
                    },
                },
            },

            // ============================================
            // NEW ADVANCED BUG DETECTION TOOLS
            // ============================================
            {
                name: 'detect_blade_errors',
                description: '🔍 ADVANCED: Detect errors in Blade templates (syntax, unmatched directives, common mistakes)',
                inputSchema: {
                    type: 'object',
                    properties: {
                        path: {
                            type: 'string',
                            description: 'Path to views directory (default: resources/views)',
                            default: 'resources/views',
                        },
                    },
                },
            },
            {
                name: 'detect_php_errors',
                description: '🔍 ADVANCED: Detect PHP backend errors (syntax, security issues, bad practices)',
                inputSchema: {
                    type: 'object',
                    properties: {
                        directory: {
                            type: 'string',
                            description: 'Directory to scan (default: app)',
                            default: 'app',
                        },
                    },
                },
            },
            {
                name: 'detect_n1_queries',
                description: '⚡ ADVANCED: Detect N+1 query problems in controllers and models',
                inputSchema: {
                    type: 'object',
                    properties: {
                        directory: {
                            type: 'string',
                            description: 'Directory to scan (default: app/Http/Controllers)',
                            default: 'app/Http/Controllers',
                        },
                    },
                },
            },
            {
                name: 'scan_security',
                description: '🛡️ ADVANCED: Scan for security vulnerabilities (SQL injection, XSS, hardcoded secrets)',
                inputSchema: {
                    type: 'object',
                    properties: {
                        directory: {
                            type: 'string',
                            description: 'Directory to scan (default: app)',
                            default: 'app',
                        },
                    },
                },
            },
            {
                name: 'analyze_dead_code',
                description: '🧹 ADVANCED: Find unused methods, variables, and imports',
                inputSchema: {
                    type: 'object',
                    properties: {
                        directory: {
                            type: 'string',
                            description: 'Directory to analyze (default: app)',
                            default: 'app',
                        },
                    },
                },
            },
            {
                name: 'analyze_code_quality',
                description: '📊 ADVANCED: Analyze code quality metrics (complexity, maintainability, comments)',
                inputSchema: {
                    type: 'object',
                    properties: {
                        file: {
                            type: 'string',
                            description: 'File path to analyze',
                        },
                    },
                    required: ['file'],
                },
            },
            {
                name: 'profile_performance',
                description: '🚀 ADVANCED: Profile performance issues (inefficient queries, memory usage)',
                inputSchema: {
                    type: 'object',
                    properties: {
                        directory: {
                            type: 'string',
                            description: 'Directory to profile (default: app/Http/Controllers)',
                            default: 'app/Http/Controllers',
                        },
                    },
                },
            },
            {
                name: 'full_bug_scan',
                description: '🔥 SUPER ADVANCED: Run ALL bug detection tools at once (comprehensive scan)',
                inputSchema: {
                    type: 'object',
                    properties: {},
                },
            },
        ],
    };
});

// ============================================
// CALL TOOL HANDLER
// ============================================

server.setRequestHandler(CallToolRequestSchema, async (request) => {
    const { name, arguments: args } = request.params;

    try {
        switch (name) {
            // ============================================
            // ORIGINAL TOOLS
            // ============================================
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
                const sanitizedQuery = args.query.trim();
                if (!sanitizedQuery.toLowerCase().startsWith('select')) {
                    throw new Error('Only SELECT queries are allowed for safety.');
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

            // ============================================
            // CODE GENERATOR TOOLS
            // ============================================

            case 'generate_model': {
                try {
                    const name = args.name;
                    const flags = [];

                    if (args.with_migration !== false) flags.push('-m');
                    if (args.with_factory) flags.push('-f');
                    if (args.with_seeder) flags.push('-s');

                    const command = `make:model ${name} ${flags.join(' ')}`;
                    const result = await runArtisanCommand(command);

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `✅ Model Generated\n\n${result.stdout || result.stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error generating model: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'generate_controller': {
                try {
                    const name = args.name;
                    const flags = [];

                    if (args.resource) flags.push('--resource');
                    if (args.api) flags.push('--api');

                    const command = `make:controller ${name} ${flags.join(' ')}`;
                    const result = await runArtisanCommand(command);

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `✅ Controller Generated\n\n${result.stdout || result.stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error generating controller: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'generate_migration': {
                try {
                    const name = args.name;
                    const flags = [];

                    if (args.table) flags.push(`--table=${args.table}`);

                    const command = `make:migration ${name} ${flags.join(' ')}`;
                    const result = await runArtisanCommand(command);

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `✅ Migration Generated\n\n${result.stdout || result.stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error generating migration: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'generate_request': {
                try {
                    const name = args.name;
                    const command = `make:request ${name}`;
                    const result = await runArtisanCommand(command);

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `✅ Form Request Generated\n\n${result.stdout || result.stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error generating request: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'generate_policy': {
                try {
                    const name = args.name;
                    const flags = [];

                    if (args.model) flags.push(`--model=${args.model}`);

                    const command = `make:policy ${name} ${flags.join(' ')}`;
                    const result = await runArtisanCommand(command);

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `✅ Policy Generated\n\n${result.stdout || result.stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error generating policy: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            // ============================================
            // DATABASE SCHEMA TOOLS
            // ============================================

            case 'show_database_schema': {
                try {
                    let query = '';
                    if (args.table) {
                        query = `DESCRIBE ${args.table}`;
                    } else {
                        query = 'SHOW TABLES';
                    }

                    const code = `DB::select("${query}");`;
                    const result = await runArtisanCommand(`tinker --execute="${code}"`);

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `📊 Database Schema\n\n${result.stdout || result.stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error showing schema: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'analyze_relationships': {
                try {
                    const models = await listDirectory('app/Models');
                    const relationships = {};

                    for (const model of models.filter(m => m.type === 'file' && m.name.endsWith('.php'))) {
                        const content = await getFileContent(model.path);
                        const modelName = model.name.replace('.php', '');

                        if (args.model && modelName !== args.model) continue;

                        relationships[modelName] = {
                            hasMany: (content.match(/public function \w+\(\)[\s\S]*?return \$this->hasMany\(/g) || []).length,
                            belongsTo: (content.match(/public function \w+\(\)[\s\S]*?return \$this->belongsTo\(/g) || []).length,
                            hasOne: (content.match(/public function \w+\(\)[\s\S]*?return \$this->hasOne\(/g) || []).length,
                            belongsToMany: (content.match(/public function \w+\(\)[\s\S]*?return \$this->belongsToMany\(/g) || []).length,
                        };
                    }

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `📊 Model Relationships Analysis\n\n${JSON.stringify(relationships, null, 2)}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error analyzing relationships: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'find_missing_indexes': {
                try {
                    const suggestions = [];
                    const migrations = await listDirectory('database/migrations');

                    for (const migration of migrations.filter(m => m.type === 'file' && m.name.endsWith('.php'))) {
                        const content = await getFileContent(migration.path);

                        // Find foreign keys without index
                        const foreignKeys = content.match(/\$table->foreignId\(['"](\w+)['"]\)/g) || [];
                        const indexes = content.match(/\$table->index\(/g) || [];

                        if (foreignKeys.length > indexes.length) {
                            suggestions.push({
                                file: migration.name,
                                message: `Found ${foreignKeys.length} foreign keys but only ${indexes.length} indexes`,
                                suggestion: 'Consider adding indexes for foreign keys',
                            });
                        }
                    }

                    return {
                        content: [
                            {
                                type: 'text',
                                text: `📊 Missing Indexes Analysis\n\n${JSON.stringify(suggestions, null, 2)}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Error finding missing indexes: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            // ============================================
            // GIT INTEGRATION TOOLS
            // ============================================

            case 'git_status': {
                try {
                    const { stdout, stderr } = await execAsync('git status', {
                        cwd: PROJECT_ROOT,
                    });
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `🌿 Git Status\n\n${stdout || stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Git status error: ${error.message}\nMake sure you're in a Git repository.`,
                            },
                        ],
                    };
                }
            }

            case 'git_log': {
                try {
                    const limit = args.limit || 10;
                    const { stdout, stderr } = await execAsync(`git log --oneline -${limit}`, {
                        cwd: PROJECT_ROOT,
                    });
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `🌿 Git Log (Last ${limit} commits)\n\n${stdout || stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Git log error: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'git_branches': {
                try {
                    const { stdout, stderr } = await execAsync('git branch -a', {
                        cwd: PROJECT_ROOT,
                    });
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `🌿 Git Branches\n\n${stdout || stderr}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Git branches error: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            case 'git_diff': {
                try {
                    let command = 'git diff';
                    if (args.staged) command += ' --staged';
                    if (args.file) command += ` ${args.file}`;

                    const { stdout, stderr } = await execAsync(command, {
                        cwd: PROJECT_ROOT,
                        maxBuffer: 1024 * 1024 * 10,
                    });
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `🌿 Git Diff\n\n${stdout || stderr || 'No changes'}`,
                            },
                        ],
                    };
                } catch (error) {
                    return {
                        content: [
                            {
                                type: 'text',
                                text: `Git diff error: ${error.message}`,
                            },
                        ],
                    };
                }
            }

            // ============================================
            // NEW ADVANCED BUG DETECTION TOOLS
            // ============================================

            case 'detect_blade_errors': {
                const errors = await detectBladeErrors(args.path || 'resources/views');

                const summary = {
                    total: errors.length,
                    byType: errors.reduce((acc, err) => {
                        acc[err.severity] = (acc[err.severity] || 0) + 1;
                        return acc;
                    }, {}),
                    errors: errors,
                };

                return {
                    content: [
                        {
                            type: 'text',
                            text: `🔍 BLADE TEMPLATE ERROR DETECTION\n\n` +
                                `Total Errors: ${summary.total}\n` +
                                `Critical: ${summary.byType.error || 0}\n` +
                                `Warnings: ${summary.byType.warning || 0}\n` +
                                `Info: ${summary.byType.info || 0}\n\n` +
                                `Detailed Report:\n` +
                                JSON.stringify(summary.errors, null, 2),
                        },
                    ],
                };
            }

            case 'detect_php_errors': {
                const errors = await detectPHPErrors(args.directory || 'app');

                const summary = {
                    total: errors.length,
                    byType: errors.reduce((acc, err) => {
                        acc[err.severity] = (acc[err.severity] || 0) + 1;
                        return acc;
                    }, {}),
                    errors: errors.slice(0, 50), // Limit to 50 for readability
                };

                return {
                    content: [
                        {
                            type: 'text',
                            text: `🔍 PHP BACKEND ERROR DETECTION\n\n` +
                                `Total Issues: ${summary.total}\n` +
                                `Critical: ${summary.byType.error || 0}\n` +
                                `Warnings: ${summary.byType.warning || 0}\n` +
                                `Info: ${summary.byType.info || 0}\n\n` +
                                `Showing first 50 issues:\n` +
                                JSON.stringify(summary.errors, null, 2),
                        },
                    ],
                };
            }

            case 'detect_n1_queries': {
                const issues = await detectN1Queries(args.directory || 'app/Http/Controllers');

                return {
                    content: [
                        {
                            type: 'text',
                            text: `⚡ N+1 QUERY DETECTION\n\n` +
                                `Total Issues Found: ${issues.length}\n\n` +
                                `Report:\n` +
                                JSON.stringify(issues, null, 2),
                        },
                    ],
                };
            }

            case 'scan_security': {
                const vulnerabilities = await scanSecurityVulnerabilities(args.directory || 'app');

                const summary = {
                    total: vulnerabilities.length,
                    bySeverity: vulnerabilities.reduce((acc, vuln) => {
                        acc[vuln.severity] = (acc[vuln.severity] || 0) + 1;
                        return acc;
                    }, {}),
                    vulnerabilities: vulnerabilities,
                };

                return {
                    content: [
                        {
                            type: 'text',
                            text: `🛡️ SECURITY VULNERABILITY SCAN\n\n` +
                                `Total Vulnerabilities: ${summary.total}\n` +
                                `Critical: ${summary.bySeverity.critical || 0}\n` +
                                `High: ${summary.bySeverity.high || 0}\n` +
                                `Medium: ${summary.bySeverity.medium || 0}\n\n` +
                                `Detailed Report:\n` +
                                JSON.stringify(summary.vulnerabilities, null, 2),
                        },
                    ],
                };
            }

            case 'analyze_dead_code': {
                const deadCode = await analyzeDeadCode(args.directory || 'app');

                return {
                    content: [
                        {
                            type: 'text',
                            text: `🧹 DEAD CODE ANALYSIS\n\n` +
                                `Unused Methods: ${deadCode.unusedMethods.length}\n` +
                                `Unused Imports: ${deadCode.unusedImports.length}\n\n` +
                                `Report:\n` +
                                JSON.stringify(deadCode, null, 2),
                        },
                    ],
                };
            }

            case 'analyze_code_quality': {
                const metrics = await analyzeCodeQuality(args.file);

                return {
                    content: [
                        {
                            type: 'text',
                            text: `📊 CODE QUALITY ANALYSIS\n\n` +
                                `File: ${metrics.file}\n` +
                                `Total Lines: ${metrics.totalLines}\n` +
                                `Code Lines: ${metrics.codeLines}\n` +
                                `Comment Lines: ${metrics.commentLines} (${metrics.commentRatio}%)\n` +
                                `Blank Lines: ${metrics.blankLines}\n` +
                                `Complexity: ${metrics.complexity}\n` +
                                `Functions: ${metrics.functions}\n` +
                                `Classes: ${metrics.classes}\n` +
                                `Maintainability Index: ${metrics.maintainabilityIndex.toFixed(2)}/100\n\n` +
                                `Issues Found: ${metrics.issues.length}\n\n` +
                                JSON.stringify(metrics.issues, null, 2),
                        },
                    ],
                };
            }

            case 'profile_performance': {
                const issues = await profilePerformance(args.directory || 'app/Http/Controllers');

                const summary = {
                    total: issues.length,
                    critical: issues.filter(i => i.severity === 'error').length,
                    warnings: issues.filter(i => i.severity === 'warning').length,
                    positive: issues.filter(i => i.severity === 'positive').length,
                    issues: issues,
                };

                return {
                    content: [
                        {
                            type: 'text',
                            text: `🚀 PERFORMANCE PROFILING\n\n` +
                                `Total Items: ${summary.total}\n` +
                                `Critical Issues: ${summary.critical}\n` +
                                `Warnings: ${summary.warnings}\n` +
                                `Good Practices: ${summary.positive}\n\n` +
                                `Detailed Report:\n` +
                                JSON.stringify(summary.issues, null, 2),
                        },
                    ],
                };
            }

            case 'full_bug_scan': {
                console.error('🔥 Starting FULL BUG SCAN...');

                const results = {
                    timestamp: new Date().toISOString(),
                    scans: {},
                };

                // Run all scans
                console.error('Scanning Blade templates...');
                results.scans.bladeErrors = await detectBladeErrors();

                console.error('Scanning PHP backend...');
                results.scans.phpErrors = await detectPHPErrors();

                console.error('Detecting N+1 queries...');
                results.scans.n1Queries = await detectN1Queries();

                console.error('Scanning security vulnerabilities...');
                results.scans.securityVulnerabilities = await scanSecurityVulnerabilities();

                console.error('Analyzing dead code...');
                results.scans.deadCode = await analyzeDeadCode();

                console.error('Profiling performance...');
                results.scans.performanceIssues = await profilePerformance();

                // Generate summary
                const summary = {
                    bladeErrors: results.scans.bladeErrors.length,
                    phpErrors: results.scans.phpErrors.length,
                    n1Queries: results.scans.n1Queries.length,
                    securityVulnerabilities: results.scans.securityVulnerabilities.length,
                    unusedMethods: results.scans.deadCode.unusedMethods.length,
                    unusedImports: results.scans.deadCode.unusedImports.length,
                    performanceIssues: results.scans.performanceIssues.length,
                };

                summary.total = Object.values(summary).reduce((a, b) => a + b, 0);

                return {
                    content: [
                        {
                            type: 'text',
                            text: `🔥 COMPREHENSIVE BUG SCAN REPORT\n\n` +
                                `Scan Date: ${results.timestamp}\n\n` +
                                `SUMMARY:\n` +
                                `========\n` +
                                `Total Issues Found: ${summary.total}\n\n` +
                                `Blade Template Errors: ${summary.bladeErrors}\n` +
                                `PHP Backend Errors: ${summary.phpErrors}\n` +
                                `N+1 Query Issues: ${summary.n1Queries}\n` +
                                `Security Vulnerabilities: ${summary.securityVulnerabilities}\n` +
                                `Unused Methods: ${summary.unusedMethods}\n` +
                                `Unused Imports: ${summary.unusedImports}\n` +
                                `Performance Issues: ${summary.performanceIssues}\n\n` +
                                `DETAILED RESULTS:\n` +
                                `=================\n` +
                                JSON.stringify(results, null, 2),
                        },
                    ],
                };
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

// ============================================
// RESOURCES (Keep original)
// ============================================

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

// ============================================
// START SERVER
// ============================================

async function main() {
    const transport = new StdioServerTransport();
    await server.connect(transport);
    console.error('🔥 IG-to-Web MCP Server v3.0 ULTIMATE running on stdio');
    console.error('✨ 31 Tools: Code Generator, DB Schema, Git Integration, Bug Detection, Security Scan');
    console.error('📦 14 Full Laravel Resources | Ready to revolutionize your workflow! 🚀');
}

main().catch((error) => {
    console.error('Server error:', error);
    process.exit(1);
});

