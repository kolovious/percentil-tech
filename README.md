# Percentil Technical Test

## 1 - Start everything (API + frontend)
```bash
make all
```

## 2 - Open the frontend
```text
http://localhost:8000
```

You can test the valuation flow directly from the frontend form or by calling the API via `curl`.

## 3 - Test API (success case)
```bash
curl -i -X POST http://localhost:8000/api/v1/valuation/estimate \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"brand":"Zara","category":"dress","condition":"good","country":"ES"}'
```

## 4 - Test API validation error (missing parameter)
Example: missing `brand` should return `422 Validation failed`.

```bash
curl -i -X POST http://localhost:8000/api/v1/valuation/estimate \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"category":"dress","condition":"good","country":"ES"}'
```

## 5 - Optional useful commands
```bash
make php-test
make front-test
make down
```

## Environment variables
- This repository includes only development-safe defaults.
- Do not commit real secrets in `.env` files in public repositories.
- Use `.env.local` for local overrides (already gitignored).
- A safe template is available in `.env.example`.

```bash
cp .env.example .env.local
```

## Technical decisions for this exercise
- The app runs without Nginx in front of PHP-FPM to keep the setup simpler and faster for the technical test.
- Symfony was set up in the required 4.4 line to match the exercise constraints.
- Vue.js 2 was added for the frontend component layer, with Webpack support to compile Vue SFCs and SCSS.
