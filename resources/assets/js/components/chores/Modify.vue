<template>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2" v-if="notification.message">
                <div class="alert text-center alert-dismissible fade show" :class="['alert-' + notification.level]" role="alert">
                    <h4 class="alert-heading" v-if="notification.level === 'danger'">Error</h4>
                    <h4 class="alert-heading" v-if="notification.level === 'success'">Success</h4>
                    <p>{{ notification.message }}</p>
                </div>
            </div>

            <div v-if="Object.keys(errors).length > 0" class="col-md-8 offset-md-2">
                <ul class="list-group list-group-flush mb-2">
                    <li class="list-group-item list-group-item-danger" v-for="(error, index) in errors">{{ error[0] }}</li>
                </ul>
            </div>

            <div class="col-md-8 offset-2">
                <div class="card mb-2">
                    <div class="card-header">
                        {{ chore.id ? 'Edit' : 'Add' }} Chore
                    </div>

                    <div class="card-body">

                        <p class="card-text text-info text-center"><span class="required">*</span> denotes required fields</p>

                        <div class="form-row mb-3"> <!-- Chore Name -->
                            <label class="col-3" for="name_id">Chore Name<span class="required">*</span></label>
                            <div class="col-6">
                                <input id="name_id" class="form-control" placeholder="Wash Dishes" v-model="chore.name" type="text">
                                <p v-if="errors.name">{{ errors.name[0] }}</p>
                            </div>
                        </div>

                        <div class="form-row mb-3"> <!-- Start Date / Time -->
                            <label class="col-3">Start Date<span class="required">*</span></label>
                            <datepicker id="start_at_id"
                                        v-model="chore.start_at.date"
                                        format="M/d/yyyy"
                                        :calendar-button="true"
                                        calendar-button-icon="fas fa-calendar"
                                        class="col-6"
                                        input-class="form-control"
                                        input-group-class="input-group"
                                        input-group-addon-class="input-group-prepend"></datepicker>
                            <div class="col-3">
                                <vue-timepicker id="start_at_time_id"
                                                class="form-control"
                                                v-model="chore.start_at_time"
                                                format="hh:mm A"
                                                :minute-interval="1"></vue-timepicker>
                            </div>
                            <p v-if="errors.start_at_date">{{ errors.start_at_date[0] }}</p>
                            <p v-if="errors.start_at_time && errors.start_at_time.hh">{{ errors.start_at_time.hh[0] }}</p>
                            <p v-if="errors.start_at_time && errors.start_at_time.mm">{{ errors.start_at_time.mm[0] }}</p>
                            <p v-if="errors.start_at_time && errors.start_at_time.A">{{ errors.start_at_time.A[0] }}</p>
                        </div>

                        <div v-show="chore.reoccurring">
                            <div class="form-row mb-3"> <!-- End Date / Time -->
                                <label for="end_at_id" class="col-sm-3">End Date</label>
                                <datepicker id="end_at_id"
                                            v-model="chore.end_at.date"
                                            format="M/d/yyyy"
                                            :calendar-button="true"
                                            calendar-button-icon="fas fa-calendar"
                                            class="col-6"
                                            input-class="form-control"
                                            input-group-class="input-group"
                                            input-group-addon-class="input-group-prepend"></datepicker>
                                <div class="col-sm-3">
                                    <vue-timepicker id="end_at_time_id"
                                                    class="form-control"
                                                    v-model="chore.end_at_time"
                                                    format="hh:mm A"
                                                    :minute-interval="1"></vue-timepicker>
                                </div>
                            </div>
                            <p v-if="errors.end_at_date">{{ errors.end_at_date[0] }}</p>
                            <p v-if="errors.end_at_time && errors.end_at_time.hh">{{ errors.end_at_time.hh[0] }}</p>
                            <p v-if="errors.end_at_time && errors.end_at_time.mm">{{ errors.end_at_time.mm[0] }}</p>
                            <p v-if="errors.end_at_time && errors.end_at_time.A">{{ errors.end_at_time.A[0] }}</p>
                        </div>

                        <div v-if="chore.reoccurring">
                            <input v-for="worker_id, i in chore.workers" type="hidden" v-bind:name="'workers[' + i + ']'" v-bind:value="worker_id">
                        </div>
                        <div v-else="">
                            <input v-if="!chore.reoccurring" type="hidden" name="workers[0]" v-bind:value="chore.workers">
                        </div>

                        <div class="form-row mb-3"> <!-- Workers -->
                            <label class="col-sm-3">Workers <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="worker in workers"><label>
                                            <input v-if="!chore.reoccurring" type="radio" name="worker" v-bind:value="worker.id" v-model="chore.workers">
                                            <input v-if="chore.reoccurring" type="checkbox" v-bind:value="worker.id" v-model="chore.workers">
                                            {{ worker.name }}
                                        </label></li>
                                    </ul>
                                </div>
                            </div>
                            <p v-if="errors.workers" class="alert alert-danger">{{ errors.workers[0] }}</p>
                        </div>

                        <div class="form-row mb-3"> <!-- Reoccurring -->
                            <label for="recurring_id" class="col-sm-3">Reoccurring</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>
                                            <input type="checkbox" id="recurring_id" name="reoccurring" v-model="chore.reoccurring"
                                                   v-on:change="toggleReoccurring"
                                                   :true-value="1"
                                                   :false-value="0">
                                            Does this chore happen more than once? If so then its a reoccurring chore!
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <p v-if="errors.reoccurring" class="alert alert-danger">{{ errors.reoccurring[0] }}</p>
                        </div>

                        <div class="form-row mb-3"> <!-- Chore Description -->

                            <label for="description_id" class="col-sm-3">Instructions</label>
                            <div class="col-sm-9">
                                <textarea rows="5" id="description_id" class="form-control" placeholder="Make sure everything is washed including pots!" v-model="chore.description" cols="50"></textarea>
                            </div>
                            <p v-if="errors.description">{{ errors.description[0] }}</p>
                        </div>

                        <div class="form-row mb-3"> <!-- Points -->
                            <label for="points_id" class="col-sm-3">Points</label>
                            <div class="col-sm-9">
                                <input id="points_id" class="form-control" placeholder="10" v-model="chore.points" type="number" value="0">
                                <p class="help-text">When a chore is completed, the worker gets rewarded with points,
                                    harder tasks should be worth more points, overall you decide what the chore is worth</p>
                            </div>
                            <p v-if="errors.points">{{ errors.points[0] }}</p>
                        </div>

                        <div v-show="chore.reoccurring">
                            <div class="form-row mb-3"> <!-- Frequency Field -->
                                <label for="email_frequency" class="col-sm-3">Frequency<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label class="radio">
                                            <input v-model="chore.frequency" id="email_frequency" type="radio" value="3" name="frequency">
                                            Daily
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="radio">
                                            <input v-model="chore.frequency" type="radio" value="2" name="frequency">
                                            Weekly
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="radio">
                                            <input v-model="chore.frequency" type="radio" value="1" name="frequency">
                                            Monthly
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="radio">
                                            <input v-model="chore.frequency" type="radio" value="4" name="frequency">
                                            Hourly
                                        </label>
                                    </div>
                                </div>
                                <p v-if="errors.frequency">{{ errors.frequency[0] }}</p>
                            </div>

                            <div class="form-row mb-3"> <!-- Interval -->
                                <label for="interval_id" class="col-sm-3">Interval<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input id="interval_id" class="form-control" placeholder="" v-model="chore.interval" type="number" value="0">
                                    <p class="help-text">Interval / Frequency = Number of Times Run, i.e 2 / Daily means
                                        every two days</p>
                                </div>
                                <p v-if="errors.interval">{{ errors.interval[0] }}</p>
                            </div>

                            <div class="form-row mb-3"> <!-- Count -->
                                <label for="count_id" class="col-sm-3">Count</label>
                                <div class="col-sm-9">
                                    <input id="count_id" class="form-control" placeholder="" v-model="chore.count" type="number" value="0">
                                    <p class="help-text">The number of times the chore can run before the end date</p>
                                </div>
                            </div>
                            <p v-if="errors.count">{{ errors.count[0] }}</p>
                        </div>
                    </div> <!-- .card-body -->

                    <div class="card-footer text-center">
                        <!-- Submit Button -->
                        <button type="submit" :disabled="processing" class="btn btn-primary" v-on:click.prevent="save">Save</button>
                    </div>
                </div> <!-- .card -->
            </div>
        </div> <!-- .row -->
        <div class="row">
            <div class="col-md-8 offset-md-2" v-if="notification.message">
                <div class="alert text-center alert-dismissible fade show" :class="['alert-' + notification.level]" role="alert">
                    <h4 class="alert-heading" v-if="notification.level === 'danger'">Error</h4>
                    <p>{{ notification.message }}</p>
                </div>
            </div>
        </div>
    </div> <!-- .container -->
</template>

<style type="text/css">
    .time-picker.form-control {
        width: 100%;
        font-size: 16px;
    }

    .time-picker.form-control input.display-time {
        border: none;
        width: 100%;
        height: initial;
        padding: 0;
        font-size: 16px;
    }
</style>

<script>
    import Datepicker from '../vuejs-datepicker/src/components/Datepicker';
    import VueTimepicker from 'vue2-timepicker';
    import * as axios from "axios";
    import Chore from "../../Chore";

    let http = axios.create({
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken
        },
        validateStatus: function (status) {
            return (status >= 200 && status < 300) || (status >= 400 && status < 500);
        }
    });

    export default {
        props: ['chore', 'workers', 'initialErrors'],

        data () {
            return {
                'notification': {
                    message: '',
                    level: ''
                },
                'processing': false,
                'errors': {}
            }
        },

        components: {
            Datepicker,
            VueTimepicker
        },

        methods: {
            toggleReoccurring() {
                if (this.chore.reoccurring) {
                    this.chore.workers = [];
                    if (!this.chore.interval) {
                        this.chore.interval = 1;
                    }

                    this.$forceUpdate();
                }
            },
            async save() {
                if (this.processing) {
                    alert('Already processing request');
                    return;
                }

                //-- Reset Errors
                this.errors = {};
                this.processing = true;
                this.notification.level = '';
                this.notification.message = '';

                try {
                    let resp = await http.post(window.Laravel.HTTP_URL + '/api/chores', this.chore);

                    if (resp.status < 300) {
                        this.notification.level = 'success';
                        this.notification.message = 'Chore has been saved';

                        this.chore = new Chore({}, this.chore.selected_workers);
                        window.scrollTo(0, 0);

                    } else {
                        this.notification.level = 'danger';
                        this.notification.message = 'There are one or more errors please review form';
                        this.errors = resp.data.errors ? resp.data.errors : {};
                    }
                } catch (e) {
                    this.notification.level = 'danger';
                    this.notification.message = 'Unable to save chore, error with server, please try again later';
                    alert('Unable to save chore, error with server');
                }

                this.processing = false;
            }
        }
    }
</script>