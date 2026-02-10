# Percentil Technical Test

## 1 - Build the test environment
```bash
make build
```

## 2 - Install dependencies
```bash
make install
```

## 3 - Start the test environment
```bash
make up
```

## 4 - Call the valuator endpoint
```bash
curl -i -X POST http://localhost:8000/api/v1/valuation/estimate \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"brand":"Zara","category":"dress","condition":"good"}'
```
