import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useProductsStore = defineStore("products", () => {
    const data = ref([]);

    const fetchProducts = async () => {
        try {
            const response = await axios.get("/products");
            data.value = response.data;
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    };

    const addProduct = async (product) => {
        try {
            const response = await axios.post("/products", product);
            data.value.push(response.data); // Add new product reactively
            await fetchProducts(); // Fetch the list of products from the server
        } catch (error) {
            console.error("Error adding product:", error);
        }
    };

    const deleteProduct = async (productId) => {
        try {
            await axios.delete(`/products/${productId}`);
            data.value = data.value.filter(
                (product) => product.id !== productId,
            ); // Remove deleted product from the array reactively
        } catch (error) {
            console.error("Error deleting product:", error);
        }
    };

    return { data, fetchProducts, addProduct, deleteProduct };
});
