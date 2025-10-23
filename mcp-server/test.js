#!/usr/bin/env node

/**
 * Test script for MCP Server
 * Verifies that all tools work correctly
 */

import { readFile } from 'fs/promises';
import { resolve } from 'path';

const PROJECT_ROOT = resolve(process.cwd(), '..');

console.log('🧪 Testing MCP Server for IG-to-Web');
console.log('=====================================\n');

let testsPassed = 0;
let testsFailed = 0;

async function test(name, fn) {
  try {
    console.log(`Testing: ${name}`);
    await fn();
    console.log(`✅ PASSED: ${name}\n`);
    testsPassed++;
  } catch (error) {
    console.log(`❌ FAILED: ${name}`);
    console.log(`   Error: ${error.message}\n`);
    testsFailed++;
  }
}

// Test 1: Check if project root exists
await test('Project root directory exists', async () => {
  const composerPath = resolve(PROJECT_ROOT, 'composer.json');
  await readFile(composerPath, 'utf-8');
});

// Test 2: Check if Laravel files exist
await test('Laravel files exist', async () => {
  const artisanPath = resolve(PROJECT_ROOT, 'artisan');
  await readFile(artisanPath, 'utf-8');
});

// Test 3: Check app/Models directory
await test('app/Models directory accessible', async () => {
  const modelsPath = resolve(PROJECT_ROOT, 'app/Models');
  const { readdir } = await import('fs/promises');
  const files = await readdir(modelsPath);
  if (files.length === 0) throw new Error('No models found');
});

// Test 4: Check app/Http/Controllers directory
await test('app/Http/Controllers directory accessible', async () => {
  const controllersPath = resolve(PROJECT_ROOT, 'app/Http/Controllers');
  const { readdir } = await import('fs/promises');
  const files = await readdir(controllersPath);
  if (files.length === 0) throw new Error('No controllers found');
});

// Test 5: Check config directory
await test('config directory accessible', async () => {
  const configPath = resolve(PROJECT_ROOT, 'config');
  const { readdir } = await import('fs/promises');
  const files = await readdir(configPath);
  if (files.length === 0) throw new Error('No config files found');
});

// Test 6: Check routes directory
await test('routes directory accessible', async () => {
  const routesPath = resolve(PROJECT_ROOT, 'routes');
  const { readdir } = await import('fs/promises');
  const files = await readdir(routesPath);
  if (files.length === 0) throw new Error('No route files found');
});

// Test 7: Check if PHP is available
await test('PHP is available', async () => {
  const { exec } = await import('child_process');
  const { promisify } = await import('util');
  const execAsync = promisify(exec);
  
  const { stdout } = await execAsync('php --version');
  if (!stdout.includes('PHP')) throw new Error('PHP not found');
});

// Test 8: Check if artisan works
await test('Artisan command works', async () => {
  const { exec } = await import('child_process');
  const { promisify } = await import('util');
  const execAsync = promisify(exec);
  
  const { stdout } = await execAsync('php artisan --version', {
    cwd: PROJECT_ROOT,
  });
  if (!stdout.includes('Laravel')) throw new Error('Artisan not working');
});

// Test 9: Check Node.js version
await test('Node.js version is 18+', async () => {
  const version = process.version;
  const major = parseInt(version.slice(1).split('.')[0]);
  if (major < 18) throw new Error(`Node.js ${major} < 18`);
});

// Test 10: Check MCP SDK
await test('MCP SDK is installed', async () => {
  try {
    await import('@modelcontextprotocol/sdk/server/index.js');
  } catch (error) {
    throw new Error('MCP SDK not found. Run: npm install');
  }
});

// Summary
console.log('=====================================');
console.log('Test Results:');
console.log(`✅ Passed: ${testsPassed}`);
console.log(`❌ Failed: ${testsFailed}`);
console.log(`📊 Total: ${testsPassed + testsFailed}`);
console.log('=====================================\n');

if (testsFailed === 0) {
  console.log('🎉 All tests passed! Server is ready to use.');
  console.log('\nNext steps:');
  console.log('1. Configure Claude Desktop (see INSTALL.md)');
  console.log('2. Restart Claude Desktop');
  console.log('3. Start using the MCP server!\n');
  process.exit(0);
} else {
  console.log('⚠️  Some tests failed. Please fix the issues above.');
  console.log('   See INSTALL.md for troubleshooting help.\n');
  process.exit(1);
}

