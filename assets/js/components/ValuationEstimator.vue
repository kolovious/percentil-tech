<template>
  <main class="valuation">
    <section class="valuation__card">
      <h1 class="valuation__title">Resale Value Estimator</h1>
      <p class="valuation__subtitle">Estimate how much a garment could be sold for on Percentil.</p>

      <form class="valuation__form" @submit.prevent="submit">
        <label class="valuation__field">
          <span class="valuation__label">Brand</span>
          <input
            v-model.trim="form.brand"
            class="valuation__input"
            type="text"
            placeholder="e.g. Zara"
            required
          />
        </label>

        <label class="valuation__field">
          <span class="valuation__label">Category</span>
          <input
            v-model.trim="form.category"
            class="valuation__input"
            type="text"
            placeholder="e.g. dress"
            required
          />
        </label>

        <label class="valuation__field">
          <span class="valuation__label">Condition</span>
          <select v-model="form.condition" class="valuation__input" required>
            <option value="new">new</option>
            <option value="good">good</option>
            <option value="fair">fair</option>
          </select>
        </label>

        <button class="valuation__button" :disabled="loading" type="submit">
          {{ loading ? "Estimating..." : "Estimate value" }}
        </button>
      </form>

      <p v-if="error" class="valuation__error">{{ error }}</p>

      <article v-if="result" class="valuation__result">
        <h2 class="valuation__resultTitle">Estimated Value</h2>
        <p class="valuation__price">
          {{ formatPrice(result.estimatedPrice) }} {{ result.currency }}
        </p>
        <p class="valuation__meta">
          Base price: {{ formatPrice(result.basePrice) }} {{ result.currency }}
        </p>
      </article>
    </section>
  </main>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ValuationEstimator',
  data() {
    return {
      loading: false,
      error: '',
      result: null,
      form: {
        brand: '',
        category: '',
        condition: 'good'
      }
    };
  },
  methods: {
    async submit() {
      this.loading = true;
      this.error = '';
      this.result = null;

      try {
        const response = await axios.post('/api/v1/valuation/estimate', this.form, {
          headers: { 'Content-Type': 'application/json' }
        });
        this.result = response.data;
      } catch (err) {
        const details = err && err.response && err.response.data ? err.response.data : null;
        if (details && details.details) {
          this.error = Object.values(details.details).join(' ');
        } else if (details && details.error) {
          this.error = details.error;
        } else {
          this.error = 'An unexpected error occurred while estimating the value.';
        }
      } finally {
        this.loading = false;
      }
    },
    formatPrice(value) {
      const numeric = Number(value);
      return Number.isFinite(numeric) ? numeric.toFixed(2) : '0.00';
    }
  }
};
</script>

<style scoped lang="scss">
.valuation {
  min-height: 100vh;
  display: grid;
  place-items: center;
  padding: 24px;
  background:
    radial-gradient(circle at 12% 10%, #ffe7d4 0%, transparent 40%),
    radial-gradient(circle at 80% 30%, #d9f6ef 0%, transparent 35%),
    linear-gradient(160deg, #f5f7fb 0%, #ecf2ff 100%);
  font-family: "Avenir Next", "Segoe UI", sans-serif;
}

.valuation__card {
  width: 100%;
  max-width: 540px;
  background: #ffffff;
  border-radius: 18px;
  border: 1px solid #dbe5ff;
  box-shadow: 0 18px 40px rgba(22, 39, 84, 0.12);
  padding: 28px;
}

.valuation__title {
  margin: 0 0 6px;
  font-size: 1.75rem;
  color: #17316b;
}

.valuation__subtitle {
  margin: 0 0 22px;
  color: #4a5a83;
}

.valuation__form {
  display: grid;
  gap: 14px;
}

.valuation__field {
  display: grid;
  gap: 6px;
}

.valuation__label {
  color: #1f2f5e;
  font-size: 0.92rem;
  font-weight: 600;
}

.valuation__input {
  border: 1px solid #b8c8ef;
  border-radius: 10px;
  font-size: 0.98rem;
  padding: 10px 12px;
  color: #23345f;
  background: #fbfcff;
}

.valuation__input:focus {
  outline: 0;
  border-color: #3574ff;
  box-shadow: 0 0 0 3px rgba(53, 116, 255, 0.16);
}

.valuation__button {
  margin-top: 6px;
  border: 0;
  border-radius: 10px;
  padding: 12px 14px;
  font-size: 1rem;
  font-weight: 700;
  color: #fff;
  background: linear-gradient(90deg, #1964ff, #2ca3ff);
  cursor: pointer;
}

.valuation__button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.valuation__error {
  margin: 14px 0 0;
  padding: 10px 12px;
  border: 1px solid #f0a8a8;
  border-radius: 10px;
  color: #7a2020;
  background: #fff3f3;
}

.valuation__result {
  margin-top: 16px;
  padding: 14px 14px 12px;
  border: 1px solid #b8ecd0;
  border-radius: 12px;
  background: #effcf5;
}

.valuation__resultTitle {
  margin: 0;
  color: #16543a;
  font-size: 1rem;
}

.valuation__price {
  margin: 8px 0 4px;
  color: #1a5b3e;
  font-weight: 800;
  font-size: 1.6rem;
}

.valuation__meta {
  margin: 0;
  color: #2f6c52;
  font-size: 0.95rem;
}
</style>
