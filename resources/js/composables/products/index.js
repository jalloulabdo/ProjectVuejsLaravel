import { ref } from "vue";

export default function useProduct(){

    const products=ref([]);
    const cartCount=ref(0);

    const getProducts = async() => {
        let response = await axios.get('api/products');

        products.value = response.data.cartContent; 
        cartCount.value= response.data.cartCount;
    }

    const add = async(productId)=>{
        let response = await axios.post('api/products',{
            productId:productId
        });

        return response.data.count
    }

    const getCount =async() => {
        let response = await axios.get('api/products/count');

       return response.data.count;
    }

    const decreaseQuantity = async (id) => {
        await axios.put('/api/products/decrease/' + id);
    }
    
    const increaseQuantity = async (id) => {
        await axios.put('/api/products/increase/' + id);
    }

    const deleteProduct = async (id) => {
        await axios.delete('/api/products/' + id);
    }

    return {
        add,
        getCount,
        products,
        getProducts,
        decreaseQuantity,
        increaseQuantity,
        deleteProduct,
        cartCount
    }
}