import Vue from "vue";
import ModifyChore from '../components/chores/Modify';
import Chore from '../Chore';

new Vue({
    el: '#add-chore',
    render: h => h(ModifyChore, {
        props: {
            chore: new Chore(chore, selected_workers),
            workers: workers
        }
    })
});