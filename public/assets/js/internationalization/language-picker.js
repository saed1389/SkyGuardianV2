(function ($) {
    "use strict";

    var LANGUAGES = {
        English: {
            columns: [
                "Base",
                "Advance",
                "scrollable",
                "Tree View",
                "Rating",
                "News",
                "Tables",
                "Base",
                "Advance",
                "scrollable",
                "Tree View",
                "Rating",
                "News",
                "Tables",
            ],
            heading: "Static Sub Nav",
        },
        German: {
            columns: [
                "Basis",
                "Fortschritt",
                "scrollable",
                "Baumansicht",
                "Die Einschaltquote",
                "Nachrichten",
                "Tische",
                "Basis",
                "Fortschritt",
                "scrollable",
                "Baumansicht",
                "Die Einschaltquote",
                "Nachrichten",
                "Tische",
            ],
            heading: "Statisches U-Boot Nav",
        },
        Russian: {
            columns: [
                "ÐžÑÐ½Ð¾Ð²Ð°",
                "ÐŸÑ€Ð¾Ð³Ñ€ÐµÑÑ",
                "Ð¿Ñ€Ð¾ÐºÑ€ÑƒÑ‡Ð¸Ð²Ð°ÐµÐ¼Ñ‹Ð¹",
                "ÐŸÑ€ÐµÐ´ÑÑ‚Ð°Ð²Ð»ÐµÐ½Ð¸Ðµ Ð”ÐµÑ€ÐµÐ²Ð°",
                "ÐžÑ†ÐµÐ½ÐºÐ°",
                "Ð½Ð¾Ð²Ð¾ÑÑ‚Ð¸",
                "Ð¡Ñ‚Ð¾Ð»Ñ‹",
                "ÐžÑÐ½Ð¾Ð²Ð°",
                "ÐŸÑ€Ð¾Ð³Ñ€ÐµÑÑ",
                "Ð¿Ñ€Ð¾ÐºÑ€ÑƒÑ‡Ð¸Ð²Ð°ÐµÐ¼Ñ‹Ð¹",
                "ÐŸÑ€ÐµÐ´ÑÑ‚Ð°Ð²Ð»ÐµÐ½Ð¸Ðµ Ð”ÐµÑ€ÐµÐ²Ð°",
                "ÐžÑ†ÐµÐ½ÐºÐ°",
                "Ð½Ð¾Ð²Ð¾ÑÑ‚Ð¸",
                "Ð¡Ñ‚Ð¾Ð»Ñ‹",
            ],
            heading: "Ð¡Ñ‚Ð°Ñ‚Ð¸Ñ‡ÐµÑÐºÐ¸Ð¹ Sub Ð’Ð¾ÐµÐ½Ð½Ð¾ - Ð¼Ð¾Ñ€ÑÐºÐ¾Ð¹",
        },
        Arabic: {
            columns: [
                "Ù‚Ø§Ø¹Ø¯Ø©",
                "Ù…Ù‚Ø¯Ù…Ø§",
                "Ø§Ù„ØªÙ…Ø±ÙŠØ±",
                "Ø¹Ø±Ø¶ Ø§Ù„Ø´Ø¬Ø±Ø©",
                "ØªØµÙ†ÙŠÙ",
                "Ø£Ø®Ø¨Ø§Ø±",
                "Ø§Ù„Ø¬Ø¯Ø§ÙˆÙ„",
                "Ù‚Ø§Ø¹Ø¯Ø©",
                "Ù…Ù‚Ø¯Ù…Ø§",
                "Ø§Ù„ØªÙ…Ø±ÙŠØ±",
                "Ø¹Ø±Ø¶ Ø§Ù„Ø´Ø¬Ø±Ø©",
                "ØªØµÙ†ÙŠÙ",
                "Ø£Ø®Ø¨Ø§Ø±",
                "Ø§Ù„Ø¬Ø¯Ø§ÙˆÙ„",
            ],
            heading: "ØµØ§ÙÙŠ Ù‚ÙŠÙ…Ø© Ø§Ù„Ø£ØµÙˆÙ„ Ø´Ø¨Ù‡ Ø§Ù„Ø«Ø§Ø¨ØªØ©",
        },
    };

    var LanguageSelector = function ($element) {
        this.$element = $element;
        this.$languageListItem = null;
        this.$languageSelect = null;
        this.$languagePageHdg = null;
        this.chosenLanguage = null;
        this.isEnabled = false;
        this.init();
    };

    LanguageSelector.prototype.init = function () {
        this.createChildren().enable();

        return this;
    };

    LanguageSelector.prototype.createChildren = function () {
        this.$languageListItem = this.$element.find("> li");
        this.$languageSelect = $(".js-languageSelect");
        this.$languagePageHdg = $(".js-languagePageHdg");

        return this;
    };

    LanguageSelector.prototype.removeChildren = function () {
        this.$languageListItem = null;
        this.$languageSelect = null;
        this.$languagePageHdg = null;

        return this;
    };

    LanguageSelector.prototype.enable = function () {
        if (this.isEnabled) {
            return this;
        }
        this.isEnabled = true;
        this.$languageSelect.on("change", $.proxy(this.changeLanguage, this));

        return this;
    };

    LanguageSelector.prototype.disable = function () {
        if (!this.isEnabled) {
            return this;
        }
        this.isEnabled = false;

        this.$languageSelect.off("change", $.proxy(this.changeLanguage, this));
        return this;
    };

    LanguageSelector.prototype.destroy = function () {
        this.disable().removeChildren();

        return this;
    };

    LanguageSelector.prototype.changeLanguage = function () {
        var numListItems = this.$languageListItem.length;

        this.chosenLanguage =
            LANGUAGES[this.$languageSelect.find(":selected").val()];

        // set the language text for each list item
        for (var i = 0; i < numListItems; i++) {
            this.$languageListItem
                .eq(i)
                .find("a")
                .text(this.chosenLanguage.columns[i]);
        }

        // set the heading text
        this.$languagePageHdg.html(this.chosenLanguage.heading);

        // set the header background color
        this.$element.css({
            background: this.chosenLanguage.background,
        });

        // set the header text color
        this.$languageListItem.find("a").css({
            color: this.chosenLanguage.color,
        });

        return this;
    };

    $(document).ready(function () {
        var languageSelector = new LanguageSelector($(".js-languageList"));
    });
})(jQuery);