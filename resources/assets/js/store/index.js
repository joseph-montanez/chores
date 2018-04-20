import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        loadedMeetups: [
            {
                imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/4/47/New_york_times_square-terabass.jpg',
                id: 'afajfjadfaadfa323',
                title: 'Meetup in New York',
                date: '2017-07-17'
            },
            {
                imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/7/7a/Paris_-_Blick_vom_gro%C3%9Fen_Triumphbogen.jpg',
                id: 'aadsfhbkhlk1241',
                title: 'Meetup in Paris',
                date: '2017-07-19'
            }
        ],
    },
    mutations: {

    },
    actions: {
        signUserUp (payload) {
            this.$http.post('api/v1/user/signup', {
                email: payload.email,
                password: payload.password,
            }).then(
                /* success */ function (a,b,c) {

                }, /* error */ function () {

            });
        }
    },
    getters: {
        loadedMeetups (state) {
            return state.loadedMeetups.sort((meetupA, meetupB) => {
                return meetupA.date > meetupB.date
            })
        },
        featuredMeetups (state, getters) {
            return getters.loadedMeetups.slice(0, 5)
        },
        loadedMeetup (state) {
            return (meetupId) => {
                return state.loadedMeetups.find((meetup) => {
                    return meetup.id === meetupId
                })
            }
        }
    }
});
