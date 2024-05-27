
import { describe, it, expect, test } from 'vitest';
import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost/api/getallbarbecues',
});

describe('BarbecuesTest', () => {
    test('it should return a list of barbecues', async () => {
        const response = await api.get();
        expect(response.status).toBe(200);
        expect(response.data).toBeInstanceOf(Array);
    }
    );
  
});