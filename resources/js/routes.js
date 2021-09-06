import brand from './components/brand/view.vue';
import products  from './components/product/view.vue';

export const routes = [
    {
        name: 'brand',
        path: '/',
        component: brand
    },
    {
        name: 'product',
        path: '/product',
        component: products
    }
   
]