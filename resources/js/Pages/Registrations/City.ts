export interface CityData {
    estado: string;
    nome?: string;
}

export function populateFormWithCityData(cityData: CityData, form: any) {
    if (cityData) { 
        form.city = cityData.nome || '';  
        form.state = cityData.estado || '';
    }
}

export async function fetchCityData(city: string, form: any) {
    try {
        const response = await fetch(`https://brasilapi.com.br/api/cptec/v1/cidade/${city}`);

        if (response.ok) {
            form.errors.city = '';
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const cityData: CityData[] = await response.json();
                form.suggestions = cityData;
            } else {
                throw new Error('Resposta não é JSON');
            }
        } else {
            const errorData = await response.json();
            form.errors.city = errorData.message || 'Erro ao buscar dados da cidade';
            form.suggestions = [];
        }
    } catch (error) {
        console.error('Error fetching cidade data:', error);
        form.suggestions = [];
    }
}

