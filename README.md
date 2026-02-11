# Percentil Technical Test

## 1 - Build PHP environment
```bash
make build
```

## 2 - Install PHP dependencies
```bash
make install
```

## 3 - Install frontend dependencies (Docker Node service)
```bash
make npm-install
```

## 4 - Build frontend assets
```bash
make front-build
```

## 5 - Start the test environment
```bash
make up
```

## 6 - Open the frontend
```text
http://localhost:8000
```

## 7 - Call the valuator endpoint
```bash
curl -i -X POST http://localhost:8000/api/v1/valuation/estimate \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"brand":"Zara","category":"dress","condition":"good"}'
```
