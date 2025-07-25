# Project Name

Symfony app designed with Domain-Driven Design (DDD) principles and scalable architectural patterns.

## Overview

This project is my attempt at scaffolding out a app that rigidly follows DDD's best practices -- starting with the User domain and context and security. It's built with the goal of maintaining a clear separation of concerns, modular design, and maintainability.

## Project Structure

```
src/
├── Domain/
│   └── <Context>/
│       ├── Entity/
│       ├── Repository/
│       ├── Event/
│       ├── Voter/
├── Application/
│   └── <Context>/
│       ├── Service/
│       ├── DTO/
├── Infrastructure/
│   └── <Context>/
│       ├── Repository/
├── UI/
│   └── Http/
│       └── Controller/
```


### Domain Layer

- **Purpose:** Contains the core business logic and domain model (Entities, domain events, interfaces, rules).
- **Characteristics:** Pure PHP, no dependencies on Symfony or infrastructure.

### Application Layer

- **Purpose:** Coordinates the use cases of the system.
- **Responsibilities:** Input validation, calling domain services or entities, orchestrating actions.

### Infrastructure Layer

- **Purpose:** Adapts infrastructure concerns such as database access, external APIs, and third-party libraries.
- **Responsibilities:** Concrete implementations of repository interfaces, message bus adapters, etc.

### UI Layer

- **Purpose:** Handles user interaction (primarily via HTTP endpoints).
- **Responsibilities:** Controllers, request/response formatting, routing.

## Tech Stack

- Symfony (PHP framework)
- Doctrine ORM
- PostgreSQL
- Composer

## Philosophy

- **Explicit boundaries:** Code responsibilities are clearly divided across layers to prevent leakage of concerns.
- **Testability:** Business logic can be unit tested independently of the framework.
- **Flexibility:** Infrastructure implementations can be swapped or extended with minimal friction.

## Getting Started

```bash
composer install
php bin/console doctrine:migrations:migrate
symfony serve
