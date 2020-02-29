import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// pages
import Issues from '@/components/Pages/Issues/Issues.vue'
import IssueItem from '@/components/Pages/Issues/IssueItem.vue'
import Projects from '@/components/Pages/Projects/Projects.vue'
import ProjectItem from '@/components/Pages/Projects/ProjectItem.vue'
import Users from '@/components/Pages/Users/Users.vue'
import UserItem from '@/components/Pages/Users/UserItem.vue'
import PageNotFound from '@/components/Pages/PageNotFound.vue'

const {urlPrefix} = window.Bugphix;

export default new VueRouter({
  mode: 'history',
  base: `${urlPrefix}/`,
  routes: [
    {
      path: `/issues/:projectId?`,
      name: 'issues',
      component: Issues,
    },
    {
      path: `/issues/:projectId/:id`,
      name: 'issue-item',
      component: IssueItem,
    },
    {
      path: `/projects`,
      name: 'projects',
      component: Projects,
    },
    {
      path: `/projects/detail/:projectId`,
      name: 'project-item',
      component: ProjectItem,
    },
    {
      path: `/users`,
      name: 'users',
      component: Users,
    },
    {
      path: `/users/detail/:userId`,
      name: 'user-item',
      component: UserItem,
    },
    {
      path: "*",
      component: PageNotFound
    }
  ]
})
