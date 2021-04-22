import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import quickCreateDigitalCard from '../components/quickCreateDigitalCardComponent.vue'
import showDigitalCard from '../components/showDigitalCardComponent.vue'
import downloadDigitalCard from '../components/downloadDigitalCardComponent.vue'
import notFound from '../components/notFoundComponent.vue'

const _numericRegx = /^\d+$/
const _alphNumericRegx = /^[A-Za-z0-9-_]+$/
const _cardNumberRegx = /^[A-Z0-9]+$/

const webRoutes = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'root.index',
            redirect: { name: 'quick.digitalCard' }
        },
        {
            path: '/create-digital-card-for-dog',
            component: quickCreateDigitalCard,
            name: 'quick.digitalCard',
        },
        {
            path: '/digital-cards/:cardNumber',
            component: showDigitalCard,
            name: 'quick.digitalCard.show',
            props: true,
            beforeEnter: (to, from, next) => {
                if (!_cardNumberRegx.test(to.params.cardNumber)) {
                    next({name: '404'})
                }
                next()
            }
        },
        {
            path: '/digital-cards/:cardNumber/download',
            component: downloadDigitalCard,
            name: 'quick.digitalCard.download',
            props: true,
            beforeEnter: (to, from, next) => {
                if (!_cardNumberRegx.test(to.params.cardNumber)) {
                    next({name: '404'})
                }
                next()
            }
        },
        {
            path: '/404',
            component: notFound,
            name: '404',
        },
        {
            path: '*',
            component: notFound
        }
    ]
});
export default webRoutes;