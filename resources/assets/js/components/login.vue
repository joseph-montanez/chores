
<v-layout row>
    <v-flex xs4>
        <v-subheader>Password</v-subheader>
    </v-flex>
    <v-flex xs8>
        <v-text-field
                name="input-10-2"
                label="Enter your password"
                hint="At least 8 characters"
                min="8"
                :append-icon="e3 ? 'visibility' : 'visibility_off'"
                :append-icon-cb="() => (e3 = !e3)"
                value=""
                type="password"
                class="input-group--focused"
        ></v-text-field>
    </v-flex>
</v-layout>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                tokens: []
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                this.getTokens();
            },

            /**
             * Get all of the authorized tokens for the user.
             */
            getTokens() {
                this.$http.get('/oauth/tokens')
                    .then(response => {
                        this.tokens = response.data;
                    });
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                this.$http.delete('/oauth/tokens/' + token.id)
                    .then(response => {
                        this.getTokens();
                    });
            }
        }
    }
</script>