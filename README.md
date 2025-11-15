# Entity Builder

Entity Builder is a full‑stack web application that helps you design and explore fictional worlds. You can create your own worlds, populate them with characters, locations, items and events, and define relationships between them (e.g., characters own items, events occur in locations). 
An interactive force‑directed graph built with D3 lets you visualise these entities and their relationships. This project is both a learning exercise and a portfolio piece demonstrating modern Laravel and Vue 3 development.

## Key Features

### User authentication 
- Registration, login and logout using Laravel Sanctum.

### World, entity and relationship CRUD
- Create, read, update and delete worlds, entities and relationships. Validation rules ensure required fields are present
and only the creator of a world can modify its contents because of policy checks.

### Interactive graph visualiser 
- A D3‑powered force‑directed graph shows entities as nodes and relationships as links. The graph supports panning, zooming, drag‑and‑drop nodes, and keyboard selection. Links have enlarged hit areas for easy clicking.

### Responsive and accessible 
- Tailwind CSS provides a responsive layout. The graph uses viewBox and percentage dimensions so it scales with the window. Nodes and links have tabindex and aria-labels; modals use role="dialog" and keyboard handlers. Colour choices aim for sufficient contrast and ARIA attributes are used where appropriate.

### State management with Pinia 
- Client‑side data is stored in a Pinia store that manages worlds, entities, relationships and selected items. Changes to the store automatically update the graph.

### Testing 
- The backend includes PHPUnit tests covering authentication, CRUD endpoints, authorisation and validation. The frontend uses Vitest and Vue Test Utils to test store actions and component behaviour. I also tried out Vue Testing Library.

## Tech Stack

- Backend: Laravel 12, PHP 8.2, Sanctum, SQLite/MySQL

- Frontend: Vue 3 + Vite, Pinia, Vue Router, Tailwind CSS

- Visualisation: D3.js

- Testing: PHPUnit (Laravel), Vitest with Vue Test Utils (frontend)

## Getting Started
### Prerequisites

- PHP 8.2+

- Node.js 20+

- Composer

- A database such as MySQL (the project defaults to SQLite for local testing)

### Installation

1. Clone the repository and install dependencies:
   ```bash
    git clone https://github.com/andris0816/entity-builder.git
    cd entity-builder
    composer install
    npm install
   ```
2. Copy `.env.example` to `.env` and configure your database credentials. Generate an application key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3. Run database migrations (and optionally seeders if you add them):
    ```bash
    php artisan migrate
    ```

4. Start the backend API:
    ```bash
    php artisan serve
    ```

5. In a separate terminal, start the Vite dev server for the frontend:
    ```bash
    npm run dev
    ```
   

### Running tests
- Laravel tests:
    ```bash
    ./vendor/bin/pest
    ```
  These feature and unit tests verify authentication, CRUD endpoints, authorisation via policies and validation rules.
- Frontend tests:
    ```bash
  npm run test
  ```
  The Vitest suite covers Pinia store mutations and Vue component rendering and events.

## Usage
1. Register for an account and log in.

2. Create a new world with a name and description.

3. Add entities (characters, locations, items or events) to the world. Entities are colour‑coded by type, and only the creator of the world can add or modify entities.

4. Create relationships between entities (e.g., a character owns an item). Validation prevents duplicate relationships and ensures entities are different.

5. Explore your world on the interactive map: zoom, pan, drag nodes and click or keyboard‑select nodes/relationships to view details. The right‑hand panel displays full details and offers edit/delete actions.

6. Edit or delete worlds, entities and relationships via the side panel.

## Future Improvements
- Advanced filtering and search to focus on subsets of the graph.
- More accessibility enhancements, such as a screen‑reader‑friendly list representation of the graph.
- Customisable entity and relationship types.
- Integration with social login providers (Google, GitHub, etc.).
- Continuous integration (CI) configuration and more comprehensive tests.
