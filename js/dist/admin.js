module.exports=function(o){var t={};function a(e){if(t[e])return t[e].exports;var n=t[e]={i:e,l:!1,exports:{}};return o[e].call(n.exports,n,n.exports,a),n.l=!0,n.exports}return a.m=o,a.c=t,a.d=function(o,t,e){a.o(o,t)||Object.defineProperty(o,t,{enumerable:!0,get:e})},a.r=function(o){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(o,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(o,"__esModule",{value:!0})},a.t=function(o,t){if(1&t&&(o=a(o)),8&t)return o;if(4&t&&"object"==typeof o&&o&&o.__esModule)return o;var e=Object.create(null);if(a.r(e),Object.defineProperty(e,"default",{enumerable:!0,value:o}),2&t&&"string"!=typeof o)for(var n in o)a.d(e,n,function(t){return o[t]}.bind(null,n));return e},a.n=function(o){var t=o&&o.__esModule?function(){return o.default}:function(){return o};return a.d(t,"a",t),t},a.o=function(o,t){return Object.prototype.hasOwnProperty.call(o,t)},a.p="",a(a.s=18)}([function(o,t){o.exports=flarum.core.compat["admin/app"]},function(o,t){o.exports=flarum.core.compat["common/utils/Stream"]},function(o,t){o.exports=flarum.core.compat["common/components/Button"]},function(o,t){o.exports=flarum.core.compat["common/Model"]},function(o,t){o.exports=flarum.core.compat["common/utils/withAttr"]},function(o,t){o.exports=flarum.core.compat["common/components/Switch"]},,function(o,t){o.exports=flarum.core.compat["common/components/Select"]},,,function(o,t){o.exports=flarum.core.compat["common/components/Alert"]},function(o,t){o.exports=flarum.core.compat["common/components/LoadingIndicator"]},function(o,t){o.exports=flarum.core.compat["common/utils/mixin"]},function(o,t){o.exports=flarum.core.compat["admin/components/ExtensionPage"]},function(o,t){o.exports=flarum.core.compat["common/Component"]},function(o,t){o.exports=flarum.core.compat["common/components/Badge"]},function(o,t){o.exports=flarum.core.compat["common/components/Modal"]},function(o,t){o.exports=flarum.core.compat["admin/utils/saveSettings"]},function(o,t,a){"use strict";a.r(t);var e=a(0),n=a.n(e);function r(o,t){o.prototype=Object.create(t.prototype),o.prototype.constructor=o,o.__proto__=t}var s=a(3),i=a.n(s),l=a(12),d=function(o){function t(){return o.apply(this,arguments)||this}return r(t,o),t.prototype.apiEndpoint=function(){return"/fof/doorkeys"+(this.exists?"/"+this.data.id:"")},t}(a.n(l)()(i.a,{id:i.a.attribute("id"),key:i.a.attribute("key"),groupId:i.a.attribute("groupId"),maxUses:i.a.attribute("maxUses"),uses:i.a.attribute("uses"),activates:i.a.attribute("activates")})),c=a(13),p=a.n(c),u=a(11),f=a.n(u),h=a(14),y=a.n(h),k=a(2),g=a.n(k),v=a(15),b=a.n(v),x=a(7),N=a.n(x),w=a(5),D=a.n(w),I=a(10),S=a.n(I),U=a(16),_=function(o){function t(){return o.apply(this,arguments)||this}r(t,o);var a=t.prototype;return a.oninit=function(t){o.prototype.oninit.call(this,t),this.emails=[],this.doorkey=this.attrs.doorkey,this.success=!1},a.className=function(){return"InviteCodeModal Modal--small"},a.title=function(){return app.translator.trans("fof-doorman.admin.modal.title")},a.oncreate=function(t){var a=this;o.prototype.oncreate.call(this,t),$("#EmailInput").off().on("keydown",(function(o){13!==o.keyCode&&188!==o.keyCode&&32!==o.keyCode||(o.preventDefault(),a.addEmails())}))},a.onremove=function(t){o.prototype.onremove.call(this,t),app.alerts.dismiss(this.alert)},a.content=function(){var o=this;return m("div",{className:"Modal-body"},m("h3",null,app.translator.trans("fof-doorman.admin.modal.group",{group:app.store.getById("groups",this.doorkey.groupId()).nameSingular()})),m("div",{className:"helpText"},app.translator.trans("fof-doorman.admin.modal.help")),m("div",{className:"Form Form--centered"},m("div",{className:"Form-group"},m("input",{type:"text",name:"text",id:"EmailInput",className:"FormControl",placeholder:app.translator.trans("fof-doorman.admin.modal.placeholder"),disabled:this.loading})),m("div",{className:"Form-group"},m("ul",null,this.emails.map((function(t,a){return m("li",{className:"emailListItem"},m("p",null,t),g.a.component({className:"Button",loading:o.loading,icon:"fas fa-times",onclick:o.removeEmail.bind(o,a)}))})))),m("div",{className:"Form-group"},g.a.component({className:"Button Button--primary Button--block",loading:this.loading,onclick:this.send.bind(this),disabled:0===this.emails.length},app.translator.trans("fof-doorman.admin.modal.send")))))},a.addEmails=function(){var o=this;app.alerts.dismiss(this.alert),m.redraw(),this.badEmails=[],$("#EmailInput").val().split(/[ ,]+/).map((function(t){o.emails.includes(t)||(o.emails.length+1>o.doorkey.data.attributes.maxUses?(o.alert=app.alerts.show(S.a,{type:"error"},app.translator.trans("fof-doorman.admin.modal.max_use_conflict")),m.redraw()):o.validateEmail(t)?(o.emails.push(t),$("#EmailInput").val(""),m.redraw()):(o.badEmails.push(t),o.alert=app.alerts.show(S.a,{type:"error"},app.translator.trans("fof-doorman.admin.modal.invalid_emails",{emails:o.badEmails.join(", ")})),m.redraw()))}))},a.validateEmail=function(o){return/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(o).toLowerCase())},a.removeEmail=function(o){this.emails.splice(o,1)},a.send=function(o){var t=this;o.preventDefault(),app.alerts.dismiss(this.alert),this.loading=!0,app.request({method:"POST",url:app.forum.attribute("apiUrl")+"/fof/doorkeys/invites",body:{emails:this.emails,doorkeyId:this.doorkey.data.id}}).then((function(){app.modal.close(),t.alert=app.alerts.show(S.a,{type:"success"},app.translator.trans("fof-doorman.admin.modal.success"))}))},t}(a.n(U).a),O=a(4),E=a.n(O),F=function(o){function t(){return o.apply(this,arguments)||this}r(t,o);var a=t.prototype;return a.oninit=function(t){o.prototype.oninit.call(this,t),this.doorkey=this.attrs.doorkey,this.doorkeys=this.attrs.doorkeys},a.view=function(){var o=this.doorkey.maxUses()-this.doorkey.uses();return m("div",{className:"DoormanSettingsListItem"},m("div",{className:"DoormanSettingsListItem-inputs"},m("input",{className:"FormControl Doorkey-key",type:"text",disabled:!0,value:this.doorkey.key(),placeholder:app.translator.trans("fof-doorman.admin.page.doorkey.key"),onchange:E()("value",this.updateKey.bind(this,this.doorkey))}),N.a.component({options:this.getGroupsForInput(),className:"Doorkey-select",onchange:this.updateGroupId.bind(this,this.doorkey),value:this.doorkey.groupId()||3}),m("input",{className:"FormControl Doorkey-maxUses",value:this.doorkey.maxUses()||"0",type:"number",placeholder:app.translator.trans("fof-doorman.admin.page.doorkey.max_uses"),onchange:E()("value",this.updateMaxUses.bind(this,this.doorkey))}),D.a.component({state:this.doorkey.activates()||!1,onchange:this.updateActivates.bind(this,this.doorkey),className:"Doorkey-switch"})),g.a.component({type:"button",className:"Button Button--warning Doorkey-button",icon:"fa fa-envelope",onclick:this.showModal.bind(this)}),g.a.component({type:"button",className:"Button Button--warning Doorkey-button",icon:"fa fa-times",onclick:this.deleteDoorkey.bind(this,this.doorkey)}),this.doorkey.maxUses()===this.doorkey.uses()?b.a.component({className:"Doorkey-badge",icon:"fas fa-user-slash",label:app.translator.trans("fof-doorman.admin.page.doorkey.warning")}):m("div",null,m("h3",{className:"Doorkey-left"},app.translator.trans("fof-doorman.admin.page.doorkey.used_times",{remaining:o}))))},a.showModal=function(){app.modal.show(_,{doorkey:this.doorkey})},a.getGroupsForInput=function(){var o=[];return app.store.all("groups").map((function(t){"Guest"!==t.nameSingular()&&(o[t.id()]=t.nameSingular())})),o},a.updateKey=function(o,t){o.save({key:t})},a.updateGroupId=function(o,t){o.save({groupId:t})},a.updateMaxUses=function(o,t){o.save({maxUses:t})},a.updateActivates=function(o,t){o.save({activates:t})},a.deleteDoorkey=function(o){var t=this;o.delete(),this.doorkeys.some((function(a,e){if(a.data.id===o.data.id)return t.doorkeys.splice(e,1),!0}))},t}(y.a),M=a(17),B=a.n(M),P=a(1),C=a.n(P),j=function(o){function t(){return o.apply(this,arguments)||this}r(t,o);var a=t.prototype;return a.oninit=function(t){o.prototype.oninit.call(this,t),this.loading=!1,this.switcherLoading=!1,this.doorkeys=n.a.store.all("doorkeys"),this.isOptional=n.a.data.settings["fof-doorman.allowPublic"],this.doorkey={key:C()(this.generateRandomKey()),groupId:C()(3),maxUses:C()(10),activates:C()(!1)}},a.content=function(){var o=this;return m("div",{className:"container Doorkey-container"},this.loading?m(f.a,null):"",m("div",{className:"Doorkeys-title"},m("h2",null,n.a.translator.trans("fof-doorman.admin.page.doorkey.title")),m("div",{className:"helpText"},n.a.translator.trans("fof-doorman.admin.page.doorkey.help.key")),m("div",{className:"helpText"},n.a.translator.trans("fof-doorman.admin.page.doorkey.help.group")),m("div",{className:"helpText"},n.a.translator.trans("fof-doorman.admin.page.doorkey.help.max")),m("div",{className:"helpText"},n.a.translator.trans("fof-doorman.admin.page.doorkey.help.activates"))),m("div",{className:"Doorkeys-fieldLabels"},m("h3",{className:"key"},n.a.translator.trans("fof-doorman.admin.page.doorkey.heading.key")),m("h3",{className:"group"},n.a.translator.trans("fof-doorman.admin.page.doorkey.heading.group")),m("h3",{className:"maxUses"},n.a.translator.trans("fof-doorman.admin.page.doorkey.heading.max_uses")),m("h3",{className:"activate"},n.a.translator.trans("fof-doorman.admin.page.doorkey.heading.activate"))),m("div",{className:"Doorkeys"},this.doorkeys.map((function(t){return F.component({doorkey:t,doorkeys:o.doorkeys})}))),m("div",{className:"Doorkeys-new"},m("div",{className:"Doorkeys-newInputs"},m("input",{className:"FormControl Doorkey-key",type:"text",value:this.doorkey.key(),placeholder:n.a.translator.trans("fof-doorman.admin.page.doorkey.key"),oninput:E()("value",this.doorkey.key)}),N.a.component({options:this.getGroupsForInput(),className:"Doorkey-select",onchange:this.doorkey.groupId,value:this.doorkey.groupId()}),m("input",{className:"FormControl Doorkey-maxUses",value:this.doorkey.maxUses(),type:"number",placeholder:n.a.translator.trans("fof-doorman.admin.page.doorkey.max_uses"),oninput:E()("value",this.doorkey.maxUses),min:"0"}),D.a.component({state:this.doorkey.activates()||!1,onchange:this.doorkey.activates,className:"Doorkey-switch"})),g.a.component({type:"button",className:"Button Button--warning Doorkey-button",icon:"fa fa-plus",onclick:this.createDoorkey.bind(this)})),m("div",{className:"Doorkey-allowPublic"},m("h2",null,n.a.translator.trans("fof-doorman.admin.page.doorkey.allow-public.title")),this.switcherLoading?m(f.a,null):m(D.a,{state:this.isOptional,onchange:this.toggleOptional.bind(this),className:"AllowPublic-switch"},n.a.translator.trans("fof-doorman.admin.page.doorkey.allow-public.switch-label"))))},a.getGroupsForInput=function(){var o=[];return n.a.store.all("groups").map((function(t){"Guest"!==t.nameSingular()&&(o[t.id()]=t.nameSingular())})),o},a.generateRandomKey=function(){return Array(9).join((Math.random().toString(36)+"00000000000000000").slice(2,18)).slice(0,8)},a.createDoorkey=function(){var o=this;n.a.store.createRecord("doorkeys").save({key:this.doorkey.key(),groupId:this.doorkey.groupId(),maxUses:this.doorkey.maxUses(),activates:this.doorkey.activates()}).then((function(t){o.doorkey.key(o.generateRandomKey()),o.doorkey.groupId(3),o.doorkey.maxUses(10),o.doorkey.activates(""),o.doorkeys.push(t),m.redraw()}))},a.toggleOptional=function(){var o=this;this.switcherLoading=!0;var t={"fof-doorman.allowPublic":!this.isOptional};B()(t).then((function(){o.isOptional=JSON.parse(n.a.data.settings["fof-doorman.allowPublic"])})).catch((function(){})).then((function(){o.switcherLoading=!1,m.redraw()}))},t}(p.a);n.a.initializers.add("fof-doorman",(function(){n.a.store.models.doorkeys=d,n.a.extensionData.for("fof-doorman").registerPage(j)}))}]);
//# sourceMappingURL=admin.js.map