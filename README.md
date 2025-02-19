## Requirements

1. NPM
2. Composer
3. PHP > 8.2

## First time setup

1. Run 'npm install'
2. Run 'composer install'
3. Run 'npm run dev'
4. Run 'php artisan key:generate'
5. Run 'php artisan migrate --seed'

## Run the system

6. Run 'php artisan serve'

## Types

-   API or UI relevant changes
    -   `feat` Commits, that add or remove a new feature to the API or UI
    -   `fix` Commits, that fix a API or UI bug of a preceded `feat` commit
-   `refactor` Commits, that rewrite/restructure your code, however do not change any API or UI behaviour
    -   `perf` Commits are special `refactor` commits, that improve performance
-   `style` Commits, that do not affect the meaning (white-space, formatting, missing semi-colons, etc)
-   `test` Commits, that add missing tests or correcting existing tests
-   `docs` Commits, that affect documentation only
-   `build` Commits, that affect build components like build tool, ci pipeline, dependencies, project version, ...
-   `ops` Commits, that affect operational components like infrastructure, deployment, backup, recovery, ...
-   `chore` Miscellaneous commits e.g. modifying `.gitignore`
