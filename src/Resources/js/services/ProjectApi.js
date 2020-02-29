import axios from 'axios';

import {serializeParams} from '@/assets/scripts/utilities';

export default {
  browse(params={}) {
    return axios({
      method: 'get',
      url: `projects${serializeParams(params)}`,
    })
  },
  show(projectId) {
    return axios({
      method: 'get',
      url: `projects/${projectId}`,
    })
  },
  create(data) {
    return  axios({
      method: 'post',
      url: `projects`,
      data,
    })
  },
  update(projectId, data) {
    return  axios({
      method: 'put',
      url: `projects/${projectId}`,
      data,
    })
  },
  getActiveProject(projectId=''){
    const url = projectId ? `/${projectId}` : '';
    return axios({
      method: 'get',
      url: `get-active-project${url}`,
    })
  },
  getProjectListOptions(){
    return axios({
      method: 'get',
      url: `get-project-list-options`,
    })
  }
};
