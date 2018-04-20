riot.tag2('login', '<header id="header"> <nav id="appbar" class="mui-container-fluid"> <table width="100%" cellspacing="0"> <tbody> <tr class="mui--appbar-height"> <td> <a class="appbar-brand" href="/docs/v1/css-js">Household Chores</a> </td> </tr> </tbody> </table> </nav> </header> <div id="appbar-placeholder" class="mui--appbar-height"></div> <div class="mui-container-fluid"> <div class="mui-row"> <div class="mui-col-sm-10 mui-col-sm-offset-1"> <div class="space-top"></div> <div class="mui-panel"> <form> <legend>Log In</legend> <div class="mui-textfield"> <input placeholder="Email" ref="email" type="email"> </div> <div class="mui-textfield"> <input type="password" placeholder="Password" ref="password"> </div> <button type="button" class="mui-btn mui-btn--raised" onclick="{login}">Login</button> </form> </div> </div> </div> </div>', '', '', function(opts) {

       var this$1 = this;
        this.app = opts.app;

        this.login = function (e) {
            this$1.app.authorize(this$1.refs.email.value, this$1.refs.password.value)
                .then(function (resp) {
                    this$1.app.updateToken(resp);
                    this$1.unmount(true);
                    riot.mount('#app', 'chores-list');
                })
                .catch(function (reason, code, responseText, result) {
                    console.log(reason);
                });
        }
});
riot.tag2('chores-list', '<header id="header" class="mui--z2"> <nav id="appbar" class="mui-container-fluid"> <table width="100%" cellspacing="0"> <tr class="mui--appbar-height"> <td> <a id="appbar-sidenav-show" class="mui--visible-xs-inline-block mui--visible-sm-inline-block"><i class="icon-menu"></i></a> <a id="appbar-sidenav-hide" class="mui--hidden-xs mui--hidden-sm"><i class="icon-menu"></i></a> <a class="appbar-brand" href="/docs/v1/css-js">Chores</a> </td> <td class="mui--text-right"> <div id="appbar-social-links" class="mui--hidden-xs"> <a href="https://github.com/muicss/mui"><i class="icon-github"></i></a> <a href="https://twitter.com/mui_css"><i class="icon-twitter"></i></a> <a href="/newsletter"><i class="icon-email"></i></a> </div> <div class="mui-dropdown"> <a id="appbar-more-vert" data-mui-toggle="dropdown"><i class="icon-more-vert"></i></a> <ul class="mui-dropdown__menu mui-dropdown__menu--right"> <li><a href="/docs/v1/getting-started/introduction">Introduction</a></li> <li><a href="/docs/v1/getting-started/roadmap">Roadmap</a></li> <li><a href="/support">Support</a></li> <li><a href="/feedback">Feedback</a></li> </ul> </div> </td> </tr> </table> </nav> </header> <button class="mui-btn mui-btn--fab mui-btn--accent action-btn mui--z3">&plus;</button> <div id="appbar-placeholder" class="mui--appbar-height"></div> <div class="mui-container-fluid"> <div class="mui-row"> <div class="mui-col-sm-10 mui-col-sm-offset-1"> <div class="space-top"></div> <div class="mui-panel"> <ul class="mui-list--unstyled"> <li each="{work in works}" class="list-item {completed: work.completed == 1}"> <div class="item-item-padding"> <div onclick="{toggleComplete}" class="radio"><div class="shape"><span class="mdi {\'mdi-checkbox-blank\': work.completed != 1,                                     \'mdi-checkbox-marked\': work.completed == 1}"></span></div></div> <div class="details"> <div class="title">{work.task.name}</div> <div class="time">{toTime(work.due_at.date)}</div> </div> <div class="note-icon" onclick="{toggleDescription}" if="{work.task.description.length > 0}}"><div class="icon"><span class="dot"></span></div></div> </div> <div class="notes" show="{work.show_description}"> {work.task.description} </div> <div class="mui-divider"></div> </li> </ul> <button class="mui-btn mui-btn--null mui-btn--danger">Add Chore</button> </div> </div> </div> </div>', 'chores-list .action-btn,[data-is="chores-list"] .action-btn{ position: fixed; top: 15px; right: 15px; z-index: 3; font-size: 2em; } chores-list .list-item .notes,[data-is="chores-list"] .list-item .notes{ background: #ffe6d5; color: rgba(43, 17, 0, 0.5); padding: 5px; } chores-list .item-item-padding,[data-is="chores-list"] .item-item-padding{ height: 56px; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: flex-start; align-content: stretch; align-items: flex-start; } chores-list .item-item-padding .radio,[data-is="chores-list"] .item-item-padding .radio{ height: 56px; order: 0; flex: 15; align-self: auto; cursor: pointer; display: flex; flex-direction: column; align-items: center; } chores-list .item-item-padding .radio .shape,[data-is="chores-list"] .item-item-padding .radio .shape{ flex: 1; display: flex; align-items: center; text-align: center; } chores-list .item-item-padding .radio .shape > span,[data-is="chores-list"] .item-item-padding .radio .shape > span{ font-size: 2em; color: #BDBDBD; } chores-list .item-item-padding .details,[data-is="chores-list"] .item-item-padding .details{ height: 56px; order: 1; flex: 70; align-self: auto; min-width: 0; display: flex; flex-direction: column; align-items: stretch; } chores-list .item-item-padding .title,[data-is="chores-list"] .item-item-padding .title{ line-height: 1em; font-weight: 600; font-size: 18px; color: #212121; flex: 1; display: flex; align-items: flex-end; } chores-list .item-item-padding .title > div,[data-is="chores-list"] .item-item-padding .title > div{ white-space: nowrap; overflow: hidden; text-overflow: ellipsis; } chores-list .item-item-padding .time,[data-is="chores-list"] .item-item-padding .time{ font-weight: 100; font-size: 12px; color: #757575; flex: 1; display: flex; align-items: flex-start; } chores-list .item-item-padding .note-icon,[data-is="chores-list"] .item-item-padding .note-icon{ height: 56px; order: 1; flex: 15; align-self: auto; text-align: center; display: flex; flex-direction: column; align-items: center; } chores-list .item-item-padding .note-icon .icon,[data-is="chores-list"] .item-item-padding .note-icon .icon{ flex: 1; display: flex; align-items: center; text-align: center; } chores-list .item-item-padding .note-icon .icon > span,[data-is="chores-list"] .item-item-padding .note-icon .icon > span{ background-color: #aa4400; padding: 5px; border-radius: 5px; } chores-list .list-item.completed .title,[data-is="chores-list"] .list-item.completed .title{ color: rgba(33, 33, 33, 0.4); } chores-list .list-item.completed .time,[data-is="chores-list"] .list-item.completed .time{ color: rgba(117, 117, 117, 0.4); } chores-list .list-item.completed .icon > span,[data-is="chores-list"] .list-item.completed .icon > span{ background-color: rgba(170, 68, 0, 0.4); }', '', function(opts) {
        this.app = opts.app;
        this.works = [];

        this.toTime = function (dateStr) {
            var dateTime = dateStr.split('.')[0].match(/(\d+)/g);;
            var d = new Date(dateTime[0], dateTime[1], dateTime[2]);
            d.setHours(dateTime[3]);
            d.setMinutes(dateTime[4]);
            d.setSeconds(dateTime[5]);

            var hours = d.getHours();
            var minutes = d.getMinutes();
            var hour = hours > 12 ? hours - 12 : hours;
            var minute = minutes < 10 ? '0' + minutes : minutes;
            var meridiem = hours > 12 ? 'AM' : 'PM';

            return (hour + ":" + minute + " " + meridiem);
        };

        this.toggleComplete = function (evt) {
            var work = evt.item.work;

            if (work.completed == 1) {
                work.completed = 0;
                work.completed_at = null;
            } else {
                work.completed = 1;
                work.completed_at = (new Date()).toISOString();
            }
        };

        this.toggleDescription = function (evt) {
            var work = evt.item.work;
            if (work.show_description != 1) {
                work.show_description = 1;
            } else {
                work.show_description = 0;
            }
        };

        this.on('mount', function () {
            var this$1 = this;

            this.app.request({
                json: true,
                url: this.app.url('/api/v1/schedule/today'),
                method: 'GET'
            }).then(function (data) {
                this$1.works = data.works;
                this$1.update();
            }).catch(function (msg) {
                //-- ACK!
                alert('Cannot fetch today\'s schedule');
            });
        });
});