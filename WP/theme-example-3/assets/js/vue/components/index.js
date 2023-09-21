import {Vue} from '../vue-prototype';

import PostsLoader from './PostsLoader';
import Deposits from './Deposits';
import EventsAndProjectsGrid from './EventsAndProjectsGrid';

Vue.component('theme-posts-loader', PostsLoader);
Vue.component('theme-events-projects-grid', EventsAndProjectsGrid);
Vue.component('theme-deposits', Deposits);
Vue.component('theme-youtube', () => import('./YoutubePlayer'));
Vue.component('theme-more-content', () => import('./MoreContent'));
