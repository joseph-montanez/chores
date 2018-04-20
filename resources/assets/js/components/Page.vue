<template>
    <v-layout column align-center>
        <div>
            <img src="./v.png" alt="Vuetify.js" class="mb-5" height="100px" />
        </div>
        <blockquote>
            &#8220;First, solve the problem. Then, write the code.&#8221;
            <footer>
                <small>
                    <em>&mdash;John Johnson</em>
                </small>
            </footer>
        </blockquote>

        <v-list two-line subheader>
            <v-subheader inset>Today&quot;s Schedule</v-subheader>
            <v-list-tile avatar v-for="task in tasks" v-bind:key="task.name">
                <v-list-tile-avatar>
                    <v-icon v-bind:class="[task.iconClass]">{{ task.icon }}</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>{{ task.name }}</v-list-tile-title>
                    <v-list-tile-sub-title>{{ task.due_at }}</v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-action>
                    <v-btn icon ripple>
                        <v-icon class="grey--text text--lighten-1">info</v-icon>
                    </v-btn>
                </v-list-tile-action>
            </v-list-tile>
        </v-list>

    </v-layout>
</template>