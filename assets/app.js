/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

const $ = require('jquery');
// start the Stimulus application
import './bootstrap';



import Vue from 'vue';

$(document).ready(() => {
        $('[data-toggle="popover"]').popover();
    });

Vue.component('button-counter', {
    data: function() {
        return {
            count: 0
        }
    },
    template: '<button v-on:click="count++">Vous m\'avez cliquez {{ count }} fois.</button>'
    
})

const app= new Vue({ el: '#components-demo' })