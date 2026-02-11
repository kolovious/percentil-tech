import { mount } from '@vue/test-utils';
import axios from 'axios';
import ValuationEstimator from '../ValuationEstimator.vue';

jest.mock('axios');

describe('ValuationEstimator', () => {
  beforeEach(() => {
    jest.clearAllMocks();
    delete process.env.VUE_APP_API_BASE;
  });

  it('uses local API endpoint by default and stores valuation result', async () => {
    const valuation = {
      estimatedPrice: 29.04,
      basePrice: 22,
      currency: 'EUR'
    };
    axios.post.mockResolvedValue({ data: valuation });

    const wrapper = mount(ValuationEstimator);
    await wrapper.setData({
      form: {
        brand: 'Zara',
        category: 'dress',
        condition: 'good'
      }
    });

    await wrapper.vm.submit();

    expect(axios.post).toHaveBeenCalledWith(
      '/api/v1/valuation/estimate',
      {
        brand: 'Zara',
        category: 'dress',
        condition: 'good'
      },
      expect.objectContaining({
        headers: expect.objectContaining({ 'Content-Type': 'application/json' })
      })

    );
    expect(wrapper.vm.result).toEqual(valuation);
    expect(wrapper.vm.error).toBe('');
  });

  it('uses configured API base URL when VUE_APP_API_BASE is provided', async () => {
    process.env.VUE_APP_API_BASE = 'https://api.example.com';
    axios.post.mockResolvedValue({ data: { estimatedPrice: 10, basePrice: 8, currency: 'EUR' } });

    const wrapper = mount(ValuationEstimator);
    await wrapper.setData({
      form: {
        brand: 'Mango',
        category: 'dress',
        condition: 'good'
      }
    });

    await wrapper.vm.submit();

    expect(axios.post).toHaveBeenCalledWith(
      'https://api.example.com/api/v1/valuation/estimate',
      expect.any(Object),
      expect.any(Object)
    );
  });

  it('clears previous valuation and error when form data changes', async () => {
    const wrapper = mount(ValuationEstimator);
    await wrapper.setData({
      result: { estimatedPrice: 20, basePrice: 10, currency: 'EUR' },
      error: 'Old error'
    });

    const brandInput = wrapper.find('input[placeholder="e.g. Zara"]');
    await brandInput.setValue('Other brand');
    await brandInput.trigger('input');
    await wrapper.vm.$nextTick();

    expect(wrapper.vm.result).toBe(null);
    expect(wrapper.vm.error).toBe('');
  });

  it('keeps submit button disabled while request is pending', async () => {
    let resolveRequest;
    const pending = new Promise((resolve) => {
      resolveRequest = resolve;
    });
    axios.post.mockReturnValue(pending);

    const wrapper = mount(ValuationEstimator);
    await wrapper.setData({
      form: {
        brand: 'Zara',
        category: 'dress',
        condition: 'good'
      }
    });

    const submitPromise = wrapper.vm.submit();
    await wrapper.vm.$nextTick();

    const button = wrapper.find('button[type="submit"]');
    expect(button.attributes('disabled')).toBe('disabled');

    resolveRequest({ data: { estimatedPrice: 29.04, basePrice: 22, currency: 'EUR' } });
    await submitPromise;
    await wrapper.vm.$nextTick();

    expect(button.attributes('disabled')).toBeUndefined();
  });
});
