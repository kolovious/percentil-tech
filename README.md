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
