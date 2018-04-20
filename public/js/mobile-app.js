(function (exports) {
'use strict';

// import nanoajax from "nanoajax";
// IENWmJJtsrNhy8FOS3nd4ExcFrs1dy2dBY60u8vf

var App = function App(clientSecret, clientId, baseUrl, csrfToken) {
    this.accessToken = localStorage.getItem('accessToken');
    this.expiresIn = localStorage.getItem('expires_in');
    this.refreshToken = localStorage.getItem('refresh_token');
    this.tokenType = localStorage.getItem('token_type');
    this.clientSecret = clientSecret;
    this.clientId = clientId;
    this.baseUrl = baseUrl;
    this.csrfToken = csrfToken;
};

App.prototype.uuid = function uuid () {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
        return v.toString(16);
    });
};

App.prototype.headers = function headers (headers, json) {
    if (!headers) {
        headers = {};
    }
    headers['X-CSRF-TOKEN'] = this.csrfToken;
    headers['Authorization'] = "Bearer " + (this.accessToken);

    if (json != null) {
        headers['Content-Type'] = 'application/json';

    }

    return headers;
};

App.prototype.url = function url (path) {
    return this.baseUrl + path;
};

App.prototype.request = function request (options) {
    if (options.json) {
        if (options.body != null) {
            options.body = JSON.stringify(options.body);
        }
        options.headers = this.headers(options.headers, true);
    }
    return new Promise(function (resolve, reject) {
        nanoajax.ajax(options, function (code, responseText, request) {
            if (code == 200) {
                try {
                    resolve(JSON.parse(responseText));
                } catch (e) {
                    reject('Failed to parse json', code, responseText, request);
                }
            } else {
                reject('Not an accepted HTTP response code', code, responseText, request);
            }
        });
    });
};


App.prototype.authorize = function authorize (username, password) {
    return this.request({
        json: true,
        url: this.url('/oauth/token'),
        method: 'POST',
        body: {
            grant_type: 'password',
            client_id: '2',
            client_secret: this.clientSecret,
            username: username,
            password: password,
            scope: '*',
        },
        headers: {}
    });
};

App.prototype.run = function run () {
    if (this.accessToken == null) {
        riot.mount('#app', 'login', {app: this});
    } else {
        riot.mount('#app', 'chores-list', {app: this});
    }
};

App.prototype.updateToken = function updateToken (resp) {
    this.accessToken = resp.access_token;
    this.expiresIn = resp.expires_in;
    this.refreshToken = resp.refresh_token;
    this.tokenType = resp.token_type;

    localStorage.setItem('accessToken', this.accessToken);
    localStorage.setItem('expiresIn', this.expiresIn);
    localStorage.setItem('refreshToken', this.refreshToken);
    localStorage.setItem('tokenType', this.tokenType);
};

window.App = App;

exports.App = App;

}((this.LaravelElixirBundle = this.LaravelElixirBundle || {})));
//# sourceMappingURL=mobile-app.js.map
