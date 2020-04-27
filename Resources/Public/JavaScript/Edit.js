"use strict";define(["jquery","TYPO3/CMS/Sessionplaner/DragDrop","TYPO3/CMS/Backend/Modal","TYPO3/CMS/Backend/Severity"],(function(e,t,s,n){var a={settings:{pageId:0,uiBlock:null,stash:null,gridButtonGroup:null,gridNewSessionButton:null,sessionData:{},ajaxActive:!1,dragActive:!1},setPageId:function(e){a.settings.pageId=e},getTemplateElement:function(t){return e(e("#"+t).html().replace(/^\s+|\s+$/g,""))},prepareData:function(t){var s={};return e.each(t,(function(e,t){"attendees"!==t.name&&"type"!==t.name&&"level"!==t.name&&"day"!==t.name&&"room"!==t.name&&"slot"!==t.name&&"hidden"!==t.name||(t.value=parseInt(t.value)||0),s[t.name]=t.value})),s},applySessionValuesToForm:function(t,s){return e.each(s,(function(s,n){var a=e("#session-form-"+s+":first",t);a.length>0&&a.val(n)})),t},applySessionValuesToCard:function(t,s){return e.each(s,(function(e,s){t.find('.property[data-name="'+e+'"]').data("value",s).text(s)})),s.hidden?t.addClass("t3-page-ce-hidden"):t.removeClass("t3-page-ce-hidden"),t},addValuesFromParent:function(e,t){return"stash"===t.attr("id")?(e.day=0,e.slot=0,e.room=0):(e.day=t.data("day"),e.slot=t.data("slot"),e.room=t.data("room")),e},createSessionCard:function(e){var t=a.getTemplateElement("sessionCardTemplate");return a.applySessionValuesToCard(t,e)},updateSessionCard:function(t){var s=e('.uid[data-value="'+t.uid+'"]',".t3js-page-ce").parents(".t3js-page-ce");a.applySessionValuesToCard(s,t)},getDataFromCard:function(t){var s={};return t.find(".t3-page-ce-body-inner .property").each((function(){var t=e(this);s[t.data("name")]=t.data("value")})),s},createSessionSuccess:function(s){a.settings.sessionData.uid=s.data.uid;var n=a.createSessionCard(a.settings.sessionData);a.settings.sessionData.room&&a.settings.sessionData.slot?e('[data-room="'+a.settings.sessionData.room+'"][data-slot="'+a.settings.sessionData.slot+'"]').prepend(n):a.settings.stash.prepend(n),t.initializeDraggable(n)},updateSessionSuccess:function(){a.updateSessionCard(a.settings.sessionData)},movedSessionSuccess:function(){},deleteSessionSuccess:function(){e('[data-name="uid"]').each((function(){var t=e(this);parseInt(t.data("value"))===a.settings.sessionData.uid&&t.parents(".t3-page-ce").remove()}))},beforeSend:function(){var e=!0;return a.settings.ajaxActive?e=!1:(a.settings.ajaxActive=!0,a.settings.uiBlock.removeClass("hidden")),e},afterSend:function(){a.settings.uiBlock.addClass("hidden"),a.settings.ajaxActive=!1},sendAjaxRequest:function(t,s,n){e.ajax(TYPO3.settings.ajaxUrls[t],{method:"post",beforeSend:function(){a.beforeSend()},complete:function(){a.afterSend()},data:{id:a.settings.pageId,tx_sessionplaner:{session:s}}}).done(n)},createSession:function(t){var s=a.prepareData(e("form",t.target).serializeArray());a.settings.sessionData=s,a.sendAjaxRequest("evoweb_sessionplaner_create",a.settings.sessionData,(function(e){"error"!==e.status?a.createSessionSuccess(e):a.createNewSessionForm(s)}))},updateSession:function(t){var s=a.prepareData(e("form",t.target).serializeArray());s.uid=a.settings.sessionData.uid,a.settings.sessionData=s,a.sendAjaxRequest("evoweb_sessionplaner_update",a.settings.sessionData,(function(e){"error"!==e.status?a.updateSessionSuccess(e):a.editSession(s)}))},deleteSession:function(t){a.settings.sessionData={uid:e(t).parents(".t3-page-ce").find(".uid").data("value")},a.sendAjaxRequest("evoweb_sessionplaner_delete",a.settings.sessionData,(function(e){a.deleteSessionSuccess(e)}))},movedSession:function(e,t){var s=a.getDataFromCard(e);a.settings.sessionData=a.addValuesFromParent(s,t),a.sendAjaxRequest("evoweb_sessionplaner_update",a.settings.sessionData,(function(e){a.movedSessionSuccess(e)}))},createNewSessionForm:function(e){a.settings.sessionData=e||{},s.confirm("Create session",a.applySessionValuesToForm(a.getTemplateElement("sessionFormTemplate"),a.settings.sessionData),n.ok,[{text:"Create session",active:!0,btnClass:"btn-default",name:"ok"},{text:"Cancel",active:!0,btnClass:"btn-default",name:"cancel"}]).on("button.clicked",(function(){s.dismiss()})).on("confirm.button.ok",(function(e){a.createSession(e)}))},createNewSessionFormInGrid:function(){s.confirm("Create session",a.applySessionValuesToForm(a.getTemplateElement("sessionFormTemplate"),a.settings.sessionData),n.ok,[{text:"Create session",active:!0,btnClass:"btn-default",name:"ok"},{text:"Cancel",active:!0,btnClass:"btn-default",name:"cancel"}]).on("button.clicked",(function(){s.dismiss()})).on("confirm.button.ok",(function(e){a.createSession(e)}))},editSession:function(e){a.settings.sessionData=e,s.confirm("Edit session",a.applySessionValuesToForm(a.getTemplateElement("sessionFormTemplate"),a.settings.sessionData),n.ok,[{text:"Update session",active:!0,btnClass:"btn-default",name:"ok"},{text:"Cancel",active:!0,btnClass:"btn-default",name:"cancel"}]).on("button.clicked",(function(){s.dismiss()})).on("confirm.button.ok",(function(e){a.updateSession(e)}))},mouseOver:function(t){var s=e(t);a.settings.sessionData={room:s.data("room"),slot:s.data("slot")},a.settings.dragActive||0!==s.children().length||a.settings.gridNewSessionButton.appendTo(s)},mouseOut:function(e,t){var s=t.toElement||t.relatedTarget;null!==s&&s!==e&&s.parentNode!==e&&s.parentNode.parentNode!==e&&s.parentNode.parentNode.parentNode!==e&&s.parentNode.parentNode.parentNode.parentNode!==e&&a.settings.gridNewSessionButton.appendTo(a.settings.gridButtonGroup)},initializeDragAndDrop:function(){var e=t.onDragStart,s=t.onDrop;t.onDragStart=function(t){a.settings.dragActive=!0,e(t)},t.onDrop=function(e,t,n){a.movedSession(e,t),s(e,t,n),a.settings.dragActive=!1}},initialize:function(){a.settings.uiBlock=e("#t3js-ui-block"),a.settings.stash=e("#stash"),a.settings.gridButtonGroup=e("#gridButtonGroup"),a.settings.gridNewSessionButton=a.settings.gridButtonGroup.find("#actions-document-new-in-grid"),a.initializeEvents()},initializeEvents:function(){e(document).on("click","#actions-document-new",(function(){a.createNewSessionForm()})).on("click","#actions-document-new-in-grid",(function(){a.createNewSessionFormInGrid()})).on("click",".icon-actions-edit-delete",(function(){a.deleteSession(this)})).on("dblclick",".t3js-page-ce",(function(){var t=a.getDataFromCard(e(this));a.editSession(t)})).on("mouseover",".t3js-grid-cell",(function(){a.mouseOver(this)})).on("mouseout",".t3js-grid-cell",(function(e){a.mouseOut(this,e)})),a.initializeDragAndDrop()}};return a.initialize(),a}));