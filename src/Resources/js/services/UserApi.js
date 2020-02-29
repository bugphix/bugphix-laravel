import axios from 'axios';

import {serializeParams} from '@/assets/scripts/utilities';

export default {
  browse(params={}) {
    return axios({
      method: 'get',
      url: `users${serializeParams(params)}`,
    })
  },
  show(userId) {
    return axios({
      method: 'get',
      url: `users/${userId}`,
    })
  },
};
