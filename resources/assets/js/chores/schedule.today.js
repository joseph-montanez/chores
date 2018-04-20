import * as axios from "axios";
import Vue from "vue";

let http = axios.create({
    headers: {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
    },
    validateStatus: function (status) {
        return (status >= 200 && status < 300) || (status >= 400 && status < 500);
    }
});

const schedule = new Vue({
    el: '#app',
    data: {
        works: works
    },
    methods: {
        async toggleDone(work_index) {
            console.log('clicked');
            var work = this.works[work_index];
            var completed = work.completed;
            var is_completed = work.completed == 1;
            work.completed = is_completed ? 0 : 1;

            try {
                let url = Laravel.HTTP_URL + '/work/' + (is_completed ? 'incomplete' : 'complete') + '/' + encodeURI(work.id);
                let resp = await http.get(url);

                if (resp.status < 300) {
                    //-- yay!
                } else {
                    alert('Error saving completed work, please try again later');
                    work.completed = completed;
                }
            } catch (e) {
                alert('Failed to communicate to server, please try again later');
                work.completed = completed;
            }

        }
    }
});