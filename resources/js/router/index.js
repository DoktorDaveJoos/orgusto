import VueRouter from 'vue-router';
import Reservations from '../components/Reservations';
import Tables from '../components/Tables';
import Restaurants from '../components/Restaurants';
import EditRestaurant from '../components/EditRestaurant';

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/app/reservations',
      name: 'reservations',
      component: Reservations,
    },
    {
      path: '/app/tables',
      name: 'tables',
      component: Tables,
    },
    {
      path: '/app/restaurants',
      name: 'restaurants',
      component: Restaurants,
    },
    {
      path: '/app/restaurants/:id',
      name: 'edit-restaurant',
      component: EditRestaurant,
    },
    {
      path: '/app/users/:id',
      name: 'edit-user',
      component: EditRestaurant,
    },
  ],
});
