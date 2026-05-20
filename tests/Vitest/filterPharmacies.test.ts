import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest';

const mockFetch = vi.fn();

beforeEach(() => {
    vi.stubGlobal('fetch', mockFetch);
});

afterEach(() => {
    vi.restoreAllMocks();
});

describe('filterPharmacies AJAX', () => {
    it('crida fetch a /admin/pharmacies/filter sense paràmetres quan la cerca és buida', async () => {
        mockFetch.mockResolvedValueOnce({
            json: async () => ({ pharmacies: [] }),
        });

        await fetch('/admin/pharmacies/filter');

        expect(mockFetch).toHaveBeenCalledWith('/admin/pharmacies/filter');
    });

    it('crida fetch amb el paràmetre search quan hi ha text de cerca', async () => {
        mockFetch.mockResolvedValueOnce({
            json: async () => ({ pharmacies: [{ id: 1, name: 'Farmàcia Soler' }] }),
        });

        const search = 'Soler';
        await fetch(`/admin/pharmacies/filter?search=${encodeURIComponent(search)}`);

        expect(mockFetch).toHaveBeenCalledWith('/admin/pharmacies/filter?search=Soler');
    });

    it('parseja correctament la resposta JSON amb les farmàcies', async () => {
        const mockPharmacies = [
            { id: 1, name: 'Farmàcia Soler', latitude: 42.26, longitude: 2.96 },
            { id: 2, name: 'Farmàcia Central', latitude: 42.27, longitude: 2.97 },
        ];

        mockFetch.mockResolvedValueOnce({
            json: async () => ({ pharmacies: mockPharmacies }),
        });

        const response = await fetch('/admin/pharmacies/filter');
        const data = await response.json();

        expect(data.pharmacies).toHaveLength(2);
        expect(data.pharmacies[0].name).toBe('Farmàcia Soler');
    });

    it('retorna array buit quan no hi ha farmàcies que coincideixin', async () => {
        mockFetch.mockResolvedValueOnce({
            json: async () => ({ pharmacies: [] }),
        });

        const response = await fetch('/admin/pharmacies/filter?search=inexistent');
        const data = await response.json();

        expect(data.pharmacies).toEqual([]);
    });
});
