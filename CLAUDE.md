# CLAUDE.md

This file provides guidance to Claude Code when working with code in this repository.

## Project Overview

Laravel application with Pest for testing, Pint for formatting, PHPStan via Larastan for static analysis, and Rector for automated refactoring.

## Commands

### Development

```bash
composer dev          # Start the local development workflow
```

### Testing

```bash
composer test                         # Run all tests with Pest
composer test:filter "test name"      # Run a specific test by name
./vendor/bin/pest --filter "test name" # Equivalent direct call
```

### Code Quality

```bash
composer qa           # Full QA pipeline
composer pint         # Auto-format with Laravel Pint
composer stan         # Static analysis with PHPStan
composer rector       # Apply Rector refactors
composer rector:dry   # Preview Rector changes without applying
```

### Setup

```bash
composer setup        # Install dependencies and prepare the local app
```

## Architecture

Standard Laravel MVC structure. Keep this section factual and tied to the repository:

- PHP files use `declare(strict_types=1)` if the project enforces it.
- Rector documents the automated refactors configured for the project.
- PHPStan/Larastan level and analysed paths should match `phpstan.neon`.
- Local database, queue, mail and frontend tooling should match the actual setup.
- Frontend stack should mention the real Vite/Tailwind configuration.
