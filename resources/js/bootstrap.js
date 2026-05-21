/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This foundation prepares the base JS framework.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
