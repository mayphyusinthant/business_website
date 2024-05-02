import { defineStore } from 'pinia';
import ApiService from '../api/ApiService';

let Timeout;

export const itemStore = defineStore('item', {
  state: () => ({
    items: [],
    categories: [],
    filteredCategory: null,
    loading: true,
  }),

  actions: {
    async fetchData(url, interval) {
        // Clear the previous timeout
        clearTimeout(Timeout);

        Timeout = setTimeout(async () => {
            try {
                this.loading = true;
                const response = await ApiService.fetchData(url);
        
                // Check if the response is empty or incomplete
                if (!response.items || !response.categories || !response.filteredCategory) {
                  console.log('Loading API Data...');
        
                  // Make a separate call to a backend route to trigger data creation or processing
                  await ApiService.fetchData(url);
        
                  // After backend processing, make the original API call again to fetch the data
                  const updatedResponse = await ApiService.fetchData(url);
                  this.items = updatedResponse.items;
                  this.categories = updatedResponse.categories;
                  this.filteredCategory = updatedResponse.filteredCategory;
                } else {
                  // Data exists, set the values as usual
                  this.items = response.items;
                  this.categories = response.categories;
                  this.filteredCategory = response.filteredCategory;
                }
              } catch (error) {
                console.error('Error fetching data:', error);
              } finally {
                this.loading = false;
                console.log('Data has been fetched ...', this.items);
              }
        }, interval)

    },
  }
});


