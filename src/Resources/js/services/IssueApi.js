import axios from 'axios';

import {serializeParams} from '@/assets/scripts/utilities';

export default {
  browse(params={}) {
    return axios({
      method: 'get',
      url: `issues${serializeParams(params)}`,
    })
  },
  show(issueId, projectId) {
    return axios({
      method: 'get',
      url: `issues/${issueId}?project_id=${projectId}`,
    })
  },
  update(issueId, data) {
    return axios({
      method: 'put',
      url: `issues/${issueId}`,
      data,
    })
  },
  delete(issueId){
    return axios({
      method: 'delete',
      url: `issues/${issueId}`
    })
  },
  bulkUpdate(issueId, data) {
    return  axios({
      method: 'put',
      url: `bulk-update/issues/${issueId}`,
      data,
    })
  },
  bulkDelete(issueId, data) {
    return  axios({
      method: 'delete',
      url: `bulk-delete/issues/${issueId}`
    })
  },
  getEvent(eventId) {
    return axios({
      method: 'get',
      url: `events/${eventId}`,
    })
  },
};
