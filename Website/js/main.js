/*jslint node: true */
/*jslint browser: true*/
/*global $, jQuery, alert*/
"use strict";
new Vue({
    el: '#app',
    data: {
        loading : true,
        output: {}
    },
    attached: function () {
        //Þetta virkar einhvernveginn
        var $this = this,
            movedata,
            stuff;
       
        $.getJSON("results.json", function (yolo) {
            movedata = yolo;
            stuff.forEach(function (element, index, array) {
                
                movedata.forEach(function (valueElement, valueIndex, valueArray) {
                    if (valueElement.date === element.Date) {
                        element.values.date = valueElement.typeName;
                        return;
                    }
                });
            });

        });
        console.log(stuff[1]);

        $this.$data.output = stuff;
        console.log($this.output);
        //loading fyrir appid
        $this.loading = false;
    }
});
