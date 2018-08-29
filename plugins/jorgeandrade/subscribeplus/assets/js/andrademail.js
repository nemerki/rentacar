+function ($) { "use strict";

    var AndradeMail = function() {

        this.init = function() {
            this.addDeleteButtons();
            this.initContentEditable();
            this.preventDefaultLinks();
            setTimeout(this._refresh, 350);
        }

        this.addDeleteButtons = function()
        {
            setTimeout(function () {
                $('button[data-id]').remove()
                var $modules = $('#content-add > tr');
                $modules.each(function(i, module){
                    var $module = $(module);
                    var id = $module.attr('id');
                    var $btn = $('<button type="button" class="btn btn-danger btn-xs abs" data-id="' + id + '"><i class="oc-icon-trash-o"></i></button>');
                    $module.append($btn);
                    $btn.on('click', function() {
                      var tr = $(this).attr('data-id');
                      return $("\#" + tr).remove();
                    });
                });
            }, 600);
        };

        this.preventDefaultLinks = function (){
            setTimeout(function () {
                $('#Form-field-Campaign-html-group').find($('a')).each(function () {
                    $(this).on('click', function (e) {
                        return e.preventDefault();
                    })
                });
            }, 600);
        }

        this.addModule = function(data) {
            var $btn, id, o, m, self;
            self = this;
            m = data.module;
            o = $(m.html);
            id = m.id + this.stringGen();
            o.attr('id', id);
            o.addClass('relative');
            $btn = $('<button type="button" class="btn btn-danger btn-xs abs" data-id="' + id + '"><i class="oc-icon-trash-o"></i></button>');
            $('#content-add').append(o);
            o.append($btn);
            $btn.on('click', function() {
              var tr;
              tr = $(this).attr('data-id');
              return $("\#" + tr).remove();
            });
            self._refresh();
            o.find($('[data-editable]')).each(function () {
                $('[data-editable]').each(function(){
                    var $this = $(this);
                    var type = $this.attr('data-editable');
                    var moduleId = $this.attr('id');
                    if (moduleId === undefined){
                        moduleId = self.createId(type);
                        $this.attr('id', moduleId);
                    };
                    var text = $this.text() || $this.attr('href');
                    var func = type+'ContentEditable';
                    var contentAdded = self[func].call(self, type, moduleId, text);
                    if (type == 'image') {
                        $this.parent().addClass('relative').append(contentAdded);
                    }else{
                        $this.append(contentAdded);
                    }
                })
            });
        }

        this.stringGen = function ()
        {
            var charset, i, len, text, _i, _len;
            text = "";
            charset = "abcdefghijklmnopqrstuvwxyz0123456789";
            len = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            for (_i = 0, _len = len.length; _i < _len; _i++) {
              i = len[_i];
              text += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            return text;
        };

        this.initContentEditable = function ()
        {
            var self = this;
            setTimeout(function (){
                $('[data-editable]').each(function(){
                    var $this = $(this);
                    var type = $this.attr('data-editable');
                    var id = $this.attr('id');
                    if (id === undefined){
                        id = self.createId(type);
                        $this.attr('id', id);
                    };
                    var text = $this.text() || $this.attr('href');
                    var func = type+'ContentEditable';
                    var contentAdded = self[func].call(self, type, id, text);
                    if (type == 'image') {
                        $this.parent().addClass('relative').append(contentAdded);
                    }else{
                        $this.append(contentAdded);
                    }
                })
            }, 500);
        }

        this.addContentEditable = function (id, text, type)
        {
            var func = type+'ContentEditable';
            var contentAdded = this[func].call(this, type, id, text);
            $('#'+id).append(contentAdded);
        }

        this.createId = function (type)
        {
            return type+'-'+this.stringGen();
        }

        this.simpleTextContentEditable = function (type, id, text)
        {
            return '<span class="content-edit"><button class="btn btn-primary btn-xs" type="button" onclick="$.andradeMail.editContent(\''+type+'\', \''+id+'\', \''+text+'\' )"><i class="icon-pencil"></i></button></span>';
        }

        this.simpleTextareaContentEditable = function (type, id, text)
        {
            return this.simpleTextContentEditable(type, id, text);
        }

        this.linkContentEditable = function (type, id, text)
        {
            return this.simpleTextContentEditable(type, id, text);
        }

        this.richEditorContentEditable = function (type, id, text)
        {
            return this.simpleTextContentEditable(type, id, text);
        }

        this.socialLinksContentEditable = function (type, id, text)
        {
            return this.simpleTextContentEditable(type, id, text);
        }

        this.socialLinkContentEditable = function (type, id, text)
        {
            return this.simpleTextContentEditable(type, id, text);
        }

        this.imageContentEditable = function (type, id, text)
        {
            return '<span class="content-edit"><button class="btn btn-primary btn-xs" type="button" onclick="$.andradeMail.imageEdit(\''+id+'\')"><i class="icon-pencil"></i></button></span>';
        }

        this.editContent = function(type, id, text) {
            var newPopup = $('<a />');
            newPopup.popup({
                handler: 'onEditContent',
                extraData: {
                    type:type,
                    id: id,
                    text: text
                }
            });
        }

        this.setContent = function(type, id)
        {
            var func = type+'Edit';
            this[func].call(this, id);
        }
        this.simpleTextEdit = function (id)
        {
            var text = $('#simpletext-input').val();
            $('#'+id).text(text);
            this.addContentEditable(id, text, 'simpleText');
        }

        this.simpleTextareaEdit = function (id)
        {
            var text = $('#simpletextarea-input').val();
            $('#'+id).text(text);
            this.addContentEditable(id, text, 'simpleTextarea');
        }

        this.linkEdit = function (id)
        {
            var text = $('#simpletext-input').val();
            $('#'+id).text(text);
        }

        this.richEditorEdit = function (id)
        {
            var text = $('#richeditor-textarea').redactor('code.get');
            var textStriped = text.replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0').replace(/\n/g, '\\n');
            $('#'+id).empty().append(text).append(this.richEditorContentEditable('richEditor', id, ''));
        }

        this.imageEdit = function (id)
        {
            new $.oc.mediaManager.popup({alias: 'ocmediamanager', onInsert: function(items) {
                    if(items.length != 1) {
                       return alert('Choose only one file.');
                    }
                    var item = items[0];
                    $("#"+id).attr('src', window.location.origin+item.publicUrl);
                    this.hide();
                } 
            });
        }

        this.socialLinksEdit = function (id)
        {
            var $this = $('#'+id);
            var href = $('#sociallink-input').val();
            var $a = $('<a />');
            $a.attr('data-editable', 'socialLink');
            var $img = $('<img />');
            var moduleId = this.createId('socialLink');
            $a.attr('id', moduleId);
            $img.attr('src', $('#social-icon-image').val());
            $a.append($img);
            $this.append($a);
            return this.addContentEditable(moduleId, href, 'socialLink');
        }

        this.socialLinkEdit = function (id)
        {
            var $this = $('#'+id);
            $this.attr('href', $('#sociallink-input').val());
            var $img = $this.find($('img'));
            $img.attr('src', $('#social-icon-image').val());
            
        }

        this.deleteLink = function(id)
        {
            return $('#'+id).remove();
        }

        this._refresh = function ()
        {
            $('#emailBody').sortable('destroy');
            $('#emailBody').sortable({
              itemPath: '#content-add',
              usePlaceholderClone: true,
              draggedClass: 'dragged',
              itemSelector: 'tr.sorted',
              placeholderClass: 'sortable-placeholder',
              placeholder: '<tr class="sortable-placeholder"/>'
            });
        }

        this.beforeUpdate = function ()
        {
            $('.content-edit').remove();
            $('button.abs').remove();
        }

    }

    $.andradeMail = new AndradeMail;
    $.andradeMail.init();

}(window.jQuery);
