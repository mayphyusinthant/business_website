import axios from 'axios';

class ApiService {
    async fetchData(url) {
        try {
          const response = await axios.get(url);
          return response.data;
        } catch (error) {
          console.error('Error fetching data:', error);
          throw error;
        }
      }
  

  // Add other API-related methods as needed
}

export default new ApiService();
