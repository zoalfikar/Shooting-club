import Vue from "vue"
const hello = Vue.component('hello', {
    template: '<h1>hello</h1>',
})
const vue = `<template><h1>hello</h1></template>`
Vue
const routes = [{
    path: '/home',
    component: hello,
    name: 'home',
}]
export default routes