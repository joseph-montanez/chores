const choreAdd=new Vue({el:"#app",data:{chore:chore,workers:workers,selected_workers:selected_workers},methods:{toggleReoccurring:function(){this.chore.reoccurring=!this.chore.reoccurring}},watch:{"chore.reoccurring":function(e){this.workers.selected_workers=[]}}});jQuery(function(e){e("#start_datetimepicker").datetimepicker(),e("#end_datetimepicker").datetimepicker()});