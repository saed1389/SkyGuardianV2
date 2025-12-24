const EmojiPicker = function (options) {
    this.options = options;
    this.trigger = this.options.trigger.map((item) => item.selector);
    this.insertInto = undefined;
    let emojiesHTML = "";
    let categoriesHTML = "";
    let emojiList = undefined;
    let moseMove = false;
    const pickerWidth = this.options.closeButton ? 370 : 350;
    const pickerHeight = 400;

    this.lib = function (el = undefined) {
        const isNodeList = (nodes) => {
            var stringRepr = Object.prototype.toString.call(nodes);

            return (
                typeof nodes === "object" &&
                /^\[object (HTMLCollection|NodeList|Object)\]$/.test(stringRepr) &&
                typeof nodes.length === "number" &&
                (nodes.length === 0 ||
                    (typeof nodes[0] === "object" && nodes[0].nodeType > 0))
            );
        };

        return {
            el: () => {
                // Check if is node
                if (!el) {
                    return undefined;
                } else if (el.nodeName) {
                    return [el];
                } else if (isNodeList(el)) {
                    return Array.from(el);
                } else if (typeof el === "string" || typeof el === "STRING") {
                    return Array.from(document.querySelectorAll(el));
                } else {
                    return undefined;
                }
            },

            on(event, callback, classList = undefined) {
                if (!classList) {
                    this.el().forEach((item) => {
                        item.addEventListener(event, callback.bind(item));
                    });
                } else {
                    this.el().forEach((item) => {
                        item.addEventListener(event, (e) => {
                            if (e.target.closest(classList)) {
                                let attr = undefined;

                                if (Array.isArray(classList)) {
                                    const stringifiedElem = e.target.outerHTML;

                                    const index = classList.findIndex((attr) =>
                                        stringifiedElem.includes(attr.slice(1))
                                    );

                                    attr = classList[index];
                                }

                                callback(e, attr);
                            }
                        });
                    });
                }
            },

            css(params) {
                for (const key in params) {
                    if (Object.hasOwnProperty.call(params, key)) {
                        const cssVal = params[key];
                        this.el().forEach((el) => (el.style[key] = cssVal));
                    }
                }
            },

            attr(param1, param2 = undefined) {
                if (!param2) {
                    return this.el()[0].getAttribute(param1);
                }
                this.el().forEach((el) => el.setAttribute(param1, param2));
            },

            removeAttr(param) {
                this.el().forEach((el) => el.removeAttribute(param));
            },

            addClass(param) {
                this.el().forEach((el) => el.classList.add(param));
            },

            removeClass(param) {
                this.el().forEach((el) => el.classList.remove(param));
            },

            slug(str) {
                return str
                    .toLowerCase()
                    .replace(/[^\u00BF-\u1FFF\u2C00-\uD7FF\w]+|[\_]+/gi, "-")
                    .replace(/ +/g, "-");
            },

            remove(param) {
                this.el().forEach((el) => el.remove());
            },

            val(param = undefined) {
                let val;

                if (param === undefined) {
                    this.el().forEach((el) => {
                        val = el.value;
                    });
                } else {
                    this.el().forEach((el) => {
                        el.value = param;
                    });
                }

                return val;
            },

            text(msg = undefined) {
                if (msg === undefined) {
                    return el.innerText;
                } else {
                    this.el().forEach((el) => {
                        el.innerText = msg;
                    });
                }
            },

            html(data = undefined) {
                if (data === undefined) {
                    return el.innerHTML;
                } else {
                    this.el().forEach((el) => {
                        el.innerHTML = data;
                    });
                }
            },
        };
    };

    const emojiObj = {
        People: [
            {
                emoji: "ðŸ˜€",
                title: "Grinning Face",
            },
            {
                emoji: "ðŸ˜ƒ",
                title: "Grinning Face with Big Eyes",
            },
            {
                emoji: "ðŸ˜„",
                title: "Grinning Face with Smiling Eyes",
            },
            {
                emoji: "ðŸ˜",
                title: "Beaming Face with Smiling Eyes",
            },
            {
                emoji: "ðŸ˜†",
                title: "Grinning Squinting Face",
            },
            {
                emoji: "ðŸ˜…",
                title: "Grinning Face with Sweat",
            },
            {
                emoji: "ðŸ¤£",
                title: "Rolling on the Floor Laughing",
            },
            {
                emoji: "ðŸ˜‚",
                title: "Face with Tears of Joy",
            },
            {
                emoji: "ðŸ™‚",
                title: "Slightly Smiling Face",
            },
            {
                emoji: "ðŸ™ƒ",
                title: "Upside-Down Face",
            },
            {
                emoji: "ðŸ˜‰",
                title: "Winking Face",
            },
            {
                emoji: "ðŸ˜Š",
                title: "Smiling Face with Smiling Eyes",
            },
            {
                emoji: "ðŸ˜‡",
                title: "Smiling Face with Halo",
            },
            {
                emoji: "ðŸ¥°",
                title: "Smiling Face with Hearts",
            },
            {
                emoji: "ðŸ˜",
                title: "Smiling Face with Heart-Eyes",
            },
            {
                emoji: "ðŸ¤©",
                title: "Star-Struck",
            },
            {
                emoji: "ðŸ˜˜",
                title: "Face Blowing a Kiss",
            },
            {
                emoji: "ðŸ˜—",
                title: "Kissing Face",
            },
            {
                emoji: "â˜ºï¸",
                title: "Smiling Face",
            },
            {
                emoji: "ðŸ˜š",
                title: "Kissing Face with Closed Eyes",
            },
            {
                emoji: "ðŸ˜™",
                title: "Kissing Face with Smiling Eyes",
            },
            {
                emoji: "ðŸ¥²",
                title: "Smiling Face with Tear",
            },
            {
                emoji: "ðŸ˜‹",
                title: "Face Savoring Food",
            },
            {
                emoji: "ðŸ˜›",
                title: "Face with Tongue",
            },
            {
                emoji: "ðŸ˜œ",
                title: "Winking Face with Tongue",
            },
            {
                emoji: "ðŸ¤ª",
                title: "Zany Face",
            },
            {
                emoji: "ðŸ˜",
                title: "Squinting Face with Tongue",
            },
            {
                emoji: "ðŸ¤‘",
                title: "Money-Mouth Face",
            },
            {
                emoji: "ðŸ¤—",
                title: "Smiling Face with Open Hands",
            },
            {
                emoji: "ðŸ¤­",
                title: "Face with Hand Over Mouth",
            },
            {
                emoji: "ðŸ¤«",
                title: "Shushing Face",
            },
            {
                emoji: "ðŸ¤”",
                title: "Thinking Face",
            },
            {
                emoji: "ðŸ¤",
                title: "Zipper-Mouth Face",
            },
            {
                emoji: "ðŸ¤¨",
                title: "Face with Raised Eyebrow",
            },
            {
                emoji: "ðŸ˜",
                title: "Neutral Face",
            },
            {
                emoji: "ðŸ˜‘",
                title: "Expressionless Face",
            },
            {
                emoji: "ðŸ˜¶",
                title: "Face Without Mouth",
            },
            {
                emoji: "ðŸ˜¶â€ðŸŒ«ï¸",
                title: "Face in Clouds",
            },
            {
                emoji: "ðŸ˜",
                title: "Smirking Face",
            },
            {
                emoji: "ðŸ˜’",
                title: "Unamused Face",
            },
            {
                emoji: "ðŸ™„",
                title: "Face with Rolling Eyes",
            },
            {
                emoji: "ðŸ˜¬",
                title: "Grimacing Face",
            },
            {
                emoji: "ðŸ˜®â€ðŸ’¨",
                title: "Face Exhaling",
            },
            {
                emoji: "ðŸ¤¥",
                title: "Lying Face",
            },
            {
                emoji: "ðŸ˜Œ",
                title: "Relieved Face",
            },
            {
                emoji: "ðŸ˜”",
                title: "Pensive Face",
            },
            {
                emoji: "ðŸ˜ª",
                title: "Sleepy Face",
            },
            {
                emoji: "ðŸ¤¤",
                title: "Drooling Face",
            },
            {
                emoji: "ðŸ˜´",
                title: "Sleeping Face",
            },
            {
                emoji: "ðŸ˜·",
                title: "Face with Medical Mask",
            },
            {
                emoji: "ðŸ¤’",
                title: "Face with Thermometer",
            },
            {
                emoji: "ðŸ¤•",
                title: "Face with Head-Bandage",
            },
            {
                emoji: "ðŸ¤¢",
                title: "Nauseated Face",
            },
            {
                emoji: "ðŸ¤®",
                title: "Face Vomiting",
            },
            {
                emoji: "ðŸ¤§",
                title: "Sneezing Face",
            },
            {
                emoji: "ðŸ¥µ",
                title: "Hot Face",
            },
            {
                emoji: "ðŸ¥¶",
                title: "Cold Face",
            },
            {
                emoji: "ðŸ¥´",
                title: "Woozy Face",
            },
            {
                emoji: "ðŸ˜µ",
                title: "Face with Crossed-Out Eyes",
            },
            {
                emoji: "ðŸ˜µâ€ðŸ’«",
                title: "Face with Spiral Eyes",
            },
            {
                emoji: "ðŸ¤¯",
                title: "Exploding Head",
            },
            {
                emoji: "ðŸ¤ ",
                title: "Cowboy Hat Face",
            },
            {
                emoji: "ðŸ¥³",
                title: "Partying Face",
            },
            {
                emoji: "ðŸ¥¸",
                title: "Disguised Face",
            },
            {
                emoji: "ðŸ˜Ž",
                title: "Smiling Face with Sunglasses",
            },
            {
                emoji: "ðŸ¤“",
                title: "Nerd Face",
            },
            {
                emoji: "ðŸ§",
                title: "Face with Monocle",
            },
            {
                emoji: "ðŸ˜•",
                title: "Confused Face",
            },
            {
                emoji: "ðŸ˜Ÿ",
                title: "Worried Face",
            },
            {
                emoji: "ðŸ™",
                title: "Slightly Frowning Face",
            },
            {
                emoji: "â˜¹ï¸",
                title: "Frowning Face",
            },
            {
                emoji: "ðŸ˜®",
                title: "Face with Open Mouth",
            },
            {
                emoji: "ðŸ˜¯",
                title: "Hushed Face",
            },
            {
                emoji: "ðŸ˜²",
                title: "Astonished Face",
            },
            {
                emoji: "ðŸ˜³",
                title: "Flushed Face",
            },
            {
                emoji: "ðŸ¥º",
                title: "Pleading Face",
            },
            {
                emoji: "ðŸ˜¦",
                title: "Frowning Face with Open Mouth",
            },
            {
                emoji: "ðŸ˜§",
                title: "Anguished Face",
            },
            {
                emoji: "ðŸ˜¨",
                title: "Fearful Face",
            },
            {
                emoji: "ðŸ˜°",
                title: "Anxious Face with Sweat",
            },
            {
                emoji: "ðŸ˜¥",
                title: "Sad but Relieved Face",
            },
            {
                emoji: "ðŸ˜¢",
                title: "Crying Face",
            },
            {
                emoji: "ðŸ˜­",
                title: "Loudly Crying Face",
            },
            {
                emoji: "ðŸ˜±",
                title: "Face Screaming in Fear",
            },
            {
                emoji: "ðŸ˜–",
                title: "Confounded Face",
            },
            {
                emoji: "ðŸ˜£",
                title: "Persevering Face",
            },
            {
                emoji: "ðŸ˜ž",
                title: "Disappointed Face",
            },
            {
                emoji: "ðŸ˜“",
                title: "Downcast Face with Sweat",
            },
            {
                emoji: "ðŸ˜©",
                title: "Weary Face",
            },
            {
                emoji: "ðŸ˜«",
                title: "Tired Face",
            },
            {
                emoji: "ðŸ¥±",
                title: "Yawning Face",
            },
            {
                emoji: "ðŸ˜¤",
                title: "Face with Steam From Nose",
            },
            {
                emoji: "ðŸ˜¡",
                title: "Enraged Face",
            },
            {
                emoji: "ðŸ˜ ",
                title: "Angry Face",
            },
            {
                emoji: "ðŸ¤¬",
                title: "Face with Symbols on Mouth",
            },
            {
                emoji: "ðŸ˜ˆ",
                title: "Smiling Face with Horns",
            },
            {
                emoji: "ðŸ‘¿",
                title: "Angry Face with Horns",
            },
            {
                emoji: "ðŸ’€",
                title: "Skull",
            },
            {
                emoji: "â˜ ï¸",
                title: "Skull and Crossbones",
            },
            {
                emoji: "ðŸ’©",
                title: "Pile of Poo",
            },
            {
                emoji: "ðŸ¤¡",
                title: "Clown Face",
            },
            {
                emoji: "ðŸ‘¹",
                title: "Ogre",
            },
            {
                emoji: "ðŸ‘º",
                title: "Goblin",
            },
            {
                emoji: "ðŸ‘»",
                title: "Ghost",
            },
            {
                emoji: "ðŸ‘½",
                title: "Alien",
            },
            {
                emoji: "ðŸ‘¾",
                title: "Alien Monster",
            },
            {
                emoji: "ðŸ¤–",
                title: "Robot",
            },
            {
                emoji: "ðŸ˜º",
                title: "Grinning Cat",
            },
            {
                emoji: "ðŸ˜¸",
                title: "Grinning Cat with Smiling Eyes",
            },
            {
                emoji: "ðŸ˜¹",
                title: "Cat with Tears of Joy",
            },
            {
                emoji: "ðŸ˜»",
                title: "Smiling Cat with Heart-Eyes",
            },
            {
                emoji: "ðŸ˜¼",
                title: "Cat with Wry Smile",
            },
            {
                emoji: "ðŸ˜½",
                title: "Kissing Cat",
            },
            {
                emoji: "ðŸ™€",
                title: "Weary Cat",
            },
            {
                emoji: "ðŸ˜¿",
                title: "Crying Cat",
            },
            {
                emoji: "ðŸ˜¾",
                title: "Pouting Cat",
            },
            {
                emoji: "ðŸ’‹",
                title: "Kiss Mark",
            },
            {
                emoji: "ðŸ‘‹",
                title: "Waving Hand",
            },
            {
                emoji: "ðŸ¤š",
                title: "Raised Back of Hand",
            },
            {
                emoji: "ðŸ–ï¸",
                title: "Hand with Fingers Splayed",
            },
            {
                emoji: "âœ‹",
                title: "Raised Hand",
            },
            {
                emoji: "ðŸ––",
                title: "Vulcan Salute",
            },
            {
                emoji: "ðŸ‘Œ",
                title: "OK Hand",
            },
            {
                emoji: "ðŸ¤Œ",
                title: "Pinched Fingers",
            },
            {
                emoji: "ðŸ¤",
                title: "Pinching Hand",
            },
            {
                emoji: "âœŒï¸",
                title: "Victory Hand",
            },
            {
                emoji: "ðŸ¤ž",
                title: "Crossed Fingers",
            },
            {
                emoji: "ðŸ¤Ÿ",
                title: "Love-You Gesture",
            },
            {
                emoji: "ðŸ¤˜",
                title: "Sign of the Horns",
            },
            {
                emoji: "ðŸ¤™",
                title: "Call Me Hand",
            },
            {
                emoji: "ðŸ‘ˆ",
                title: "Backhand Index Pointing Left",
            },
            {
                emoji: "ðŸ‘‰",
                title: "Backhand Index Pointing Right",
            },
            {
                emoji: "ðŸ‘†",
                title: "Backhand Index Pointing Up",
            },
            {
                emoji: "ðŸ–•",
                title: "Middle Finger",
            },
            {
                emoji: "ðŸ‘‡",
                title: "Backhand Index Pointing Down",
            },
            {
                emoji: "â˜ï¸",
                title: "Index Pointing Up",
            },
            {
                emoji: "ðŸ‘",
                title: "Thumbs Up",
            },
            {
                emoji: "ðŸ‘Ž",
                title: "Thumbs Down",
            },
            {
                emoji: "âœŠ",
                title: "Raised Fist",
            },
            {
                emoji: "ðŸ‘Š",
                title: "Oncoming Fist",
            },
            {
                emoji: "ðŸ¤›",
                title: "Left-Facing Fist",
            },
            {
                emoji: "ðŸ¤œ",
                title: "Right-Facing Fist",
            },
            {
                emoji: "ðŸ‘",
                title: "Clapping Hands",
            },
            {
                emoji: "ðŸ™Œ",
                title: "Raising Hands",
            },
            {
                emoji: "ðŸ‘",
                title: "Open Hands",
            },
            {
                emoji: "ðŸ¤²",
                title: "Palms Up Together",
            },
            {
                emoji: "ðŸ¤",
                title: "Handshake",
            },
            {
                emoji: "ðŸ™",
                title: "Folded Hands",
            },
            {
                emoji: "âœï¸",
                title: "Writing Hand",
            },
            {
                emoji: "ðŸ’…",
                title: "Nail Polish",
            },
            {
                emoji: "ðŸ¤³",
                title: "Selfie",
            },
            {
                emoji: "ðŸ’ª",
                title: "Flexed Biceps",
            },
            {
                emoji: "ðŸ¦¾",
                title: "Mechanical Arm",
            },
            {
                emoji: "ðŸ¦¿",
                title: "Mechanical Leg",
            },
            {
                emoji: "ðŸ¦µ",
                title: "Leg",
            },
            {
                emoji: "ðŸ¦¶",
                title: "Foot",
            },
            {
                emoji: "ðŸ‘‚",
                title: "Ear",
            },
            {
                emoji: "ðŸ¦»",
                title: "Ear with Hearing Aid",
            },
            {
                emoji: "ðŸ‘ƒ",
                title: "Nose",
            },
            {
                emoji: "ðŸ§ ",
                title: "Brain",
            },
            {
                emoji: "ðŸ«€",
                title: "Anatomical Heart",
            },
            {
                emoji: "ðŸ«",
                title: "Lungs",
            },
            {
                emoji: "ðŸ¦·",
                title: "Tooth",
            },
            {
                emoji: "ðŸ¦´",
                title: "Bone",
            },
            {
                emoji: "ðŸ‘€",
                title: "Eyes",
            },
            {
                emoji: "ðŸ‘ï¸",
                title: "Eye",
            },
            {
                emoji: "ðŸ‘…",
                title: "Tongue",
            },
            {
                emoji: "ðŸ‘„",
                title: "Mouth",
            },
            {
                emoji: "ðŸ‘¶",
                title: "Baby",
            },
            {
                emoji: "ðŸ§’",
                title: "Child",
            },
            {
                emoji: "ðŸ‘¦",
                title: "Boy",
            },
            {
                emoji: "ðŸ‘§",
                title: "Girl",
            },
            {
                emoji: "ðŸ§‘",
                title: "Person",
            },
            {
                emoji: "ðŸ‘±",
                title: "Person: Blond Hair",
            },
            {
                emoji: "ðŸ‘¨",
                title: "Man",
            },
            {
                emoji: "ðŸ§”",
                title: "Person: Beard",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¦°",
                title: "Man: Red Hair",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¦±",
                title: "Man: Curly Hair",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¦³",
                title: "Man: White Hair",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¦²",
                title: "Man: Bald",
            },
            {
                emoji: "ðŸ‘©",
                title: "Woman",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¦°",
                title: "Woman: Red Hair",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¦°",
                title: "Person: Red Hair",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¦±",
                title: "Woman: Curly Hair",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¦±",
                title: "Person: Curly Hair",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¦³",
                title: "Woman: White Hair",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¦³",
                title: "Person: White Hair",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¦²",
                title: "Woman: Bald",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¦²",
                title: "Person: Bald",
            },
            {
                emoji: "ðŸ‘±â€â™€ï¸",
                title: "Woman: Blond Hair",
            },
            {
                emoji: "ðŸ‘±â€â™‚ï¸",
                title: "Man: Blond Hair",
            },
            {
                emoji: "ðŸ§“",
                title: "Older Person",
            },
            {
                emoji: "ðŸ‘´",
                title: "Old Man",
            },
            {
                emoji: "ðŸ‘µ",
                title: "Old Woman",
            },
            {
                emoji: "ðŸ™",
                title: "Person Frowning",
            },
            {
                emoji: "ðŸ™â€â™‚ï¸",
                title: "Man Frowning",
            },
            {
                emoji: "ðŸ™â€â™€ï¸",
                title: "Woman Frowning",
            },
            {
                emoji: "ðŸ™Ž",
                title: "Person Pouting",
            },
            {
                emoji: "ðŸ™Žâ€â™‚ï¸",
                title: "Man Pouting",
            },
            {
                emoji: "ðŸ™Žâ€â™€ï¸",
                title: "Woman Pouting",
            },
            {
                emoji: "ðŸ™…",
                title: "Person Gesturing No",
            },
            {
                emoji: "ðŸ™…â€â™‚ï¸",
                title: "Man Gesturing No",
            },
            {
                emoji: "ðŸ™…â€â™€ï¸",
                title: "Woman Gesturing No",
            },
            {
                emoji: "ðŸ™†",
                title: "Person Gesturing OK",
            },
            {
                emoji: "ðŸ™†â€â™‚ï¸",
                title: "Man Gesturing OK",
            },
            {
                emoji: "ðŸ™†â€â™€ï¸",
                title: "Woman Gesturing OK",
            },
            {
                emoji: "ðŸ’",
                title: "Person Tipping Hand",
            },
            {
                emoji: "ðŸ’â€â™‚ï¸",
                title: "Man Tipping Hand",
            },
            {
                emoji: "ðŸ’â€â™€ï¸",
                title: "Woman Tipping Hand",
            },
            {
                emoji: "ðŸ™‹",
                title: "Person Raising Hand",
            },
            {
                emoji: "ðŸ™‹â€â™‚ï¸",
                title: "Man Raising Hand",
            },
            {
                emoji: "ðŸ™‹â€â™€ï¸",
                title: "Woman Raising Hand",
            },
            {
                emoji: "ðŸ§",
                title: "Deaf Person",
            },
            {
                emoji: "ðŸ§â€â™‚ï¸",
                title: "Deaf Man",
            },
            {
                emoji: "ðŸ§â€â™€ï¸",
                title: "Deaf Woman",
            },
            {
                emoji: "ðŸ™‡",
                title: "Person Bowing",
            },
            {
                emoji: "ðŸ™‡â€â™‚ï¸",
                title: "Man Bowing",
            },
            {
                emoji: "ðŸ™‡â€â™€ï¸",
                title: "Woman Bowing",
            },
            {
                emoji: "ðŸ¤¦",
                title: "Person Facepalming",
            },
            {
                emoji: "ðŸ¤¦â€â™‚ï¸",
                title: "Man Facepalming",
            },
            {
                emoji: "ðŸ¤¦â€â™€ï¸",
                title: "Woman Facepalming",
            },
            {
                emoji: "ðŸ¤·",
                title: "Person Shrugging",
            },
            {
                emoji: "ðŸ¤·â€â™‚ï¸",
                title: "Man Shrugging",
            },
            {
                emoji: "ðŸ¤·â€â™€ï¸",
                title: "Woman Shrugging",
            },
            {
                emoji: "ðŸ§‘â€âš•ï¸",
                title: "Health Worker",
            },
            {
                emoji: "ðŸ‘¨â€âš•ï¸",
                title: "Man Health Worker",
            },
            {
                emoji: "ðŸ‘©â€âš•ï¸",
                title: "Woman Health Worker",
            },
            {
                emoji: "ðŸ§‘â€ðŸŽ“",
                title: "Student",
            },
            {
                emoji: "ðŸ‘¨â€ðŸŽ“",
                title: "Man Student",
            },
            {
                emoji: "ðŸ‘©â€ðŸŽ“",
                title: "Woman Student",
            },
            {
                emoji: "ðŸ§‘â€ðŸ«",
                title: "Teacher",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ«",
                title: "Man Teacher",
            },
            {
                emoji: "ðŸ‘©â€ðŸ«",
                title: "Woman Teacher",
            },
            {
                emoji: "ðŸ§‘â€âš–ï¸",
                title: "Judge",
            },
            {
                emoji: "ðŸ‘¨â€âš–ï¸",
                title: "Man Judge",
            },
            {
                emoji: "ðŸ‘©â€âš–ï¸",
                title: "Woman Judge",
            },
            {
                emoji: "ðŸ§‘â€ðŸŒ¾",
                title: "Farmer",
            },
            {
                emoji: "ðŸ‘¨â€ðŸŒ¾",
                title: "Man Farmer",
            },
            {
                emoji: "ðŸ‘©â€ðŸŒ¾",
                title: "Woman Farmer",
            },
            {
                emoji: "ðŸ§‘â€ðŸ³",
                title: "Cook",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ³",
                title: "Man Cook",
            },
            {
                emoji: "ðŸ‘©â€ðŸ³",
                title: "Woman Cook",
            },
            {
                emoji: "ðŸ§‘â€ðŸ”§",
                title: "Mechanic",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ”§",
                title: "Man Mechanic",
            },
            {
                emoji: "ðŸ‘©â€ðŸ”§",
                title: "Woman Mechanic",
            },
            {
                emoji: "ðŸ§‘â€ðŸ­",
                title: "Factory Worker",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ­",
                title: "Man Factory Worker",
            },
            {
                emoji: "ðŸ‘©â€ðŸ­",
                title: "Woman Factory Worker",
            },
            {
                emoji: "ðŸ§‘â€ðŸ’¼",
                title: "Office Worker",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ’¼",
                title: "Man Office Worker",
            },
            {
                emoji: "ðŸ‘©â€ðŸ’¼",
                title: "Woman Office Worker",
            },
            {
                emoji: "ðŸ§‘â€ðŸ”¬",
                title: "Scientist",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ”¬",
                title: "Man Scientist",
            },
            {
                emoji: "ðŸ‘©â€ðŸ”¬",
                title: "Woman Scientist",
            },
            {
                emoji: "ðŸ§‘â€ðŸ’»",
                title: "Technologist",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ’»",
                title: "Man Technologist",
            },
            {
                emoji: "ðŸ‘©â€ðŸ’»",
                title: "Woman Technologist",
            },
            {
                emoji: "ðŸ§‘â€ðŸŽ¤",
                title: "Singer",
            },
            {
                emoji: "ðŸ‘¨â€ðŸŽ¤",
                title: "Man Singer",
            },
            {
                emoji: "ðŸ‘©â€ðŸŽ¤",
                title: "Woman Singer",
            },
            {
                emoji: "ðŸ§‘â€ðŸŽ¨",
                title: "Artist",
            },
            {
                emoji: "ðŸ‘¨â€ðŸŽ¨",
                title: "Man Artist",
            },
            {
                emoji: "ðŸ‘©â€ðŸŽ¨",
                title: "Woman Artist",
            },
            {
                emoji: "ðŸ§‘â€âœˆï¸",
                title: "Pilot",
            },
            {
                emoji: "ðŸ‘¨â€âœˆï¸",
                title: "Man Pilot",
            },
            {
                emoji: "ðŸ‘©â€âœˆï¸",
                title: "Woman Pilot",
            },
            {
                emoji: "ðŸ§‘â€ðŸš€",
                title: "Astronaut",
            },
            {
                emoji: "ðŸ‘¨â€ðŸš€",
                title: "Man Astronaut",
            },
            {
                emoji: "ðŸ‘©â€ðŸš€",
                title: "Woman Astronaut",
            },
            {
                emoji: "ðŸ§‘â€ðŸš’",
                title: "Firefighter",
            },
            {
                emoji: "ðŸ‘¨â€ðŸš’",
                title: "Man Firefighter",
            },
            {
                emoji: "ðŸ‘©â€ðŸš’",
                title: "Woman Firefighter",
            },
            {
                emoji: "ðŸ‘®",
                title: "Police Officer",
            },
            {
                emoji: "ðŸ‘®â€â™‚ï¸",
                title: "Man Police Officer",
            },
            {
                emoji: "ðŸ‘®â€â™€ï¸",
                title: "Woman Police Officer",
            },
            {
                emoji: "ðŸ•µï¸",
                title: "Detective",
            },
            {
                emoji: "ðŸ•µï¸â€â™‚ï¸",
                title: "Man Detective",
            },
            {
                emoji: "ðŸ•µï¸â€â™€ï¸",
                title: "Woman Detective",
            },
            {
                emoji: "ðŸ’‚",
                title: "Guard",
            },
            {
                emoji: "ðŸ’‚â€â™‚ï¸",
                title: "Man Guard",
            },
            {
                emoji: "ðŸ’‚â€â™€ï¸",
                title: "Woman Guard",
            },
            {
                emoji: "ðŸ¥·",
                title: "Ninja",
            },
            {
                emoji: "ðŸ‘·",
                title: "Construction Worker",
            },
            {
                emoji: "ðŸ‘·â€â™‚ï¸",
                title: "Man Construction Worker",
            },
            {
                emoji: "ðŸ‘·â€â™€ï¸",
                title: "Woman Construction Worker",
            },
            {
                emoji: "ðŸ¤´",
                title: "Prince",
            },
            {
                emoji: "ðŸ‘¸",
                title: "Princess",
            },
            {
                emoji: "ðŸ‘³",
                title: "Person Wearing Turban",
            },
            {
                emoji: "ðŸ‘³â€â™‚ï¸",
                title: "Man Wearing Turban",
            },
            {
                emoji: "ðŸ‘³â€â™€ï¸",
                title: "Woman Wearing Turban",
            },
            {
                emoji: "ðŸ‘²",
                title: "Person with Skullcap",
            },
            {
                emoji: "ðŸ§•",
                title: "Woman with Headscarf",
            },
            {
                emoji: "ðŸ¤µ",
                title: "Person in Tuxedo",
            },
            {
                emoji: "ðŸ¤µâ€â™‚ï¸",
                title: "Man in Tuxedo",
            },
            {
                emoji: "ðŸ¤µâ€â™€ï¸",
                title: "Woman in Tuxedo",
            },
            {
                emoji: "ðŸ‘°",
                title: "Person with Veil",
            },
            {
                emoji: "ðŸ‘°â€â™‚ï¸",
                title: "Man with Veil",
            },
            {
                emoji: "ðŸ‘°â€â™€ï¸",
                title: "Woman with Veil",
            },
            {
                emoji: "ðŸ¤°",
                title: "Pregnant Woman",
            },
            {
                emoji: "ðŸ¤±",
                title: "Breast-Feeding",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¼",
                title: "Woman Feeding Baby",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¼",
                title: "Man Feeding Baby",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¼",
                title: "Person Feeding Baby",
            },
            {
                emoji: "ðŸ‘¼",
                title: "Baby Angel",
            },
            {
                emoji: "ðŸŽ…",
                title: "Santa Claus",
            },
            {
                emoji: "ðŸ¤¶",
                title: "Mrs. Claus",
            },
            {
                emoji: "ðŸ§‘â€ðŸŽ„",
                title: "Mx Claus",
            },
            {
                emoji: "ðŸ¦¸",
                title: "Superhero",
            },
            {
                emoji: "ðŸ¦¸â€â™‚ï¸",
                title: "Man Superhero",
            },
            {
                emoji: "ðŸ¦¸â€â™€ï¸",
                title: "Woman Superhero",
            },
            {
                emoji: "ðŸ¦¹",
                title: "Supervillain",
            },
            {
                emoji: "ðŸ¦¹â€â™‚ï¸",
                title: "Man Supervillain",
            },
            {
                emoji: "ðŸ¦¹â€â™€ï¸",
                title: "Woman Supervillain",
            },
            {
                emoji: "ðŸ§™",
                title: "Mage",
            },
            {
                emoji: "ðŸ§™â€â™‚ï¸",
                title: "Man Mage",
            },
            {
                emoji: "ðŸ§™â€â™€ï¸",
                title: "Woman Mage",
            },
            {
                emoji: "ðŸ§š",
                title: "Fairy",
            },
            {
                emoji: "ðŸ§šâ€â™‚ï¸",
                title: "Man Fairy",
            },
            {
                emoji: "ðŸ§šâ€â™€ï¸",
                title: "Woman Fairy",
            },
            {
                emoji: "ðŸ§›",
                title: "Vampire",
            },
            {
                emoji: "ðŸ§›â€â™‚ï¸",
                title: "Man Vampire",
            },
            {
                emoji: "ðŸ§›â€â™€ï¸",
                title: "Woman Vampire",
            },
            {
                emoji: "ðŸ§œ",
                title: "Merperson",
            },
            {
                emoji: "ðŸ§œâ€â™‚ï¸",
                title: "Merman",
            },
            {
                emoji: "ðŸ§œâ€â™€ï¸",
                title: "Mermaid",
            },
            {
                emoji: "ðŸ§",
                title: "Elf",
            },
            {
                emoji: "ðŸ§â€â™‚ï¸",
                title: "Man Elf",
            },
            {
                emoji: "ðŸ§â€â™€ï¸",
                title: "Woman Elf",
            },
            {
                emoji: "ðŸ§ž",
                title: "Genie",
            },
            {
                emoji: "ðŸ§žâ€â™‚ï¸",
                title: "Man Genie",
            },
            {
                emoji: "ðŸ§žâ€â™€ï¸",
                title: "Woman Genie",
            },
            {
                emoji: "ðŸ§Ÿ",
                title: "Zombie",
            },
            {
                emoji: "ðŸ§Ÿâ€â™‚ï¸",
                title: "Man Zombie",
            },
            {
                emoji: "ðŸ§Ÿâ€â™€ï¸",
                title: "Woman Zombie",
            },
            {
                emoji: "ðŸ’†",
                title: "Person Getting Massage",
            },
            {
                emoji: "ðŸ’†â€â™‚ï¸",
                title: "Man Getting Massage",
            },
            {
                emoji: "ðŸ’†â€â™€ï¸",
                title: "Woman Getting Massage",
            },
            {
                emoji: "ðŸ’‡",
                title: "Person Getting Haircut",
            },
            {
                emoji: "ðŸ’‡â€â™‚ï¸",
                title: "Man Getting Haircut",
            },
            {
                emoji: "ðŸ’‡â€â™€ï¸",
                title: "Woman Getting Haircut",
            },
            {
                emoji: "ðŸš¶",
                title: "Person Walking",
            },
            {
                emoji: "ðŸš¶â€â™‚ï¸",
                title: "Man Walking",
            },
            {
                emoji: "ðŸš¶â€â™€ï¸",
                title: "Woman Walking",
            },
            {
                emoji: "ðŸ§",
                title: "Person Standing",
            },
            {
                emoji: "ðŸ§â€â™‚ï¸",
                title: "Man Standing",
            },
            {
                emoji: "ðŸ§â€â™€ï¸",
                title: "Woman Standing",
            },
            {
                emoji: "ðŸ§Ž",
                title: "Person Kneeling",
            },
            {
                emoji: "ðŸ§Žâ€â™‚ï¸",
                title: "Man Kneeling",
            },
            {
                emoji: "ðŸ§Žâ€â™€ï¸",
                title: "Woman Kneeling",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¦¯",
                title: "Person with White Cane",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¦¯",
                title: "Man with White Cane",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¦¯",
                title: "Woman with White Cane",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¦¼",
                title: "Person in Motorized Wheelchair",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¦¼",
                title: "Man in Motorized Wheelchair",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¦¼",
                title: "Woman in Motorized Wheelchair",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¦½",
                title: "Person in Manual Wheelchair",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ¦½",
                title: "Man in Manual Wheelchair",
            },
            {
                emoji: "ðŸ‘©â€ðŸ¦½",
                title: "Woman in Manual Wheelchair",
            },
            {
                emoji: "ðŸƒ",
                title: "Person Running",
            },
            {
                emoji: "ðŸƒâ€â™‚ï¸",
                title: "Man Running",
            },
            {
                emoji: "ðŸƒâ€â™€ï¸",
                title: "Woman Running",
            },
            {
                emoji: "ðŸ’ƒ",
                title: "Woman Dancing",
            },
            {
                emoji: "ðŸ•º",
                title: "Man Dancing",
            },
            {
                emoji: "ðŸ•´ï¸",
                title: "Person in Suit Levitating",
            },
            {
                emoji: "ðŸ‘¯",
                title: "People with Bunny Ears",
            },
            {
                emoji: "ðŸ‘¯â€â™‚ï¸",
                title: "Men with Bunny Ears",
            },
            {
                emoji: "ðŸ‘¯â€â™€ï¸",
                title: "Women with Bunny Ears",
            },
            {
                emoji: "ðŸ§–",
                title: "Person in Steamy Room",
            },
            {
                emoji: "ðŸ§–â€â™‚ï¸",
                title: "Man in Steamy Room",
            },
            {
                emoji: "ðŸ§–â€â™€ï¸",
                title: "Woman in Steamy Room",
            },
            {
                emoji: "ðŸ§˜",
                title: "Person in Lotus Position",
            },
            {
                emoji: "ðŸ§‘â€ðŸ¤â€ðŸ§‘",
                title: "People Holding Hands",
            },
            {
                emoji: "ðŸ‘­",
                title: "Women Holding Hands",
            },
            {
                emoji: "ðŸ‘«",
                title: "Woman and Man Holding Hands",
            },
            {
                emoji: "ðŸ‘¬",
                title: "Men Holding Hands",
            },
            {
                emoji: "ðŸ’",
                title: "Kiss",
            },
            {
                emoji: "ðŸ‘©â€â¤ï¸â€ðŸ’‹â€ðŸ‘¨",
                title: "Kiss: Woman, Man",
            },
            {
                emoji: "ðŸ‘¨â€â¤ï¸â€ðŸ’‹â€ðŸ‘¨",
                title: "Kiss: Man, Man",
            },
            {
                emoji: "ðŸ‘©â€â¤ï¸â€ðŸ’‹â€ðŸ‘©",
                title: "Kiss: Woman, Woman",
            },
            {
                emoji: "ðŸ’‘",
                title: "Couple with Heart",
            },
            {
                emoji: "ðŸ‘©â€â¤ï¸â€ðŸ‘¨",
                title: "Couple with Heart: Woman, Man",
            },
            {
                emoji: "ðŸ‘¨â€â¤ï¸â€ðŸ‘¨",
                title: "Couple with Heart: Man, Man",
            },
            {
                emoji: "ðŸ‘©â€â¤ï¸â€ðŸ‘©",
                title: "Couple with Heart: Woman, Woman",
            },
            {
                emoji: "ðŸ‘ª",
                title: "Family",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘©â€ðŸ‘¦",
                title: "Family: Man, Woman, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘©â€ðŸ‘§",
                title: "Family: Man, Woman, Girl",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘©â€ðŸ‘§â€ðŸ‘¦",
                title: "Family: Man, Woman, Girl, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘©â€ðŸ‘¦â€ðŸ‘¦",
                title: "Family: Man, Woman, Boy, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘©â€ðŸ‘§â€ðŸ‘§",
                title: "Family: Man, Woman, Girl, Girl",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘¨â€ðŸ‘¦",
                title: "Family: Man, Man, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘¨â€ðŸ‘§",
                title: "Family: Man, Man, Girl",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘¨â€ðŸ‘§â€ðŸ‘¦",
                title: "Family: Man, Man, Girl, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘¨â€ðŸ‘¦â€ðŸ‘¦",
                title: "Family: Man, Man, Boy, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘¨â€ðŸ‘§â€ðŸ‘§",
                title: "Family: Man, Man, Girl, Girl",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘©â€ðŸ‘¦",
                title: "Family: Woman, Woman, Boy",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘©â€ðŸ‘§",
                title: "Family: Woman, Woman, Girl",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘©â€ðŸ‘§â€ðŸ‘¦",
                title: "Family: Woman, Woman, Girl, Boy",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘©â€ðŸ‘¦â€ðŸ‘¦",
                title: "Family: Woman, Woman, Boy, Boy",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘©â€ðŸ‘§â€ðŸ‘§",
                title: "Family: Woman, Woman, Girl, Girl",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘¦",
                title: "Family: Man, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘¦â€ðŸ‘¦",
                title: "Family: Man, Boy, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘§",
                title: "Family: Man, Girl",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘§â€ðŸ‘¦",
                title: "Family: Man, Girl, Boy",
            },
            {
                emoji: "ðŸ‘¨â€ðŸ‘§â€ðŸ‘§",
                title: "Family: Man, Girl, Girl",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘¦",
                title: "Family: Woman, Boy",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘¦â€ðŸ‘¦",
                title: "Family: Woman, Boy, Boy",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘§",
                title: "Family: Woman, Girl",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘§â€ðŸ‘¦",
                title: "Family: Woman, Girl, Boy",
            },
            {
                emoji: "ðŸ‘©â€ðŸ‘§â€ðŸ‘§",
                title: "Family: Woman, Girl, Girl",
            },
            {
                emoji: "ðŸ—£ï¸",
                title: "Speaking Head",
            },
            {
                emoji: "ðŸ‘¤",
                title: "Bust in Silhouette",
            },
            {
                emoji: "ðŸ‘¥",
                title: "Busts in Silhouette",
            },
            {
                emoji: "ðŸ«‚",
                title: "People Hugging",
            },
            {
                emoji: "ðŸ‘£",
                title: "Footprints",
            },
            {
                emoji: "ðŸ§³",
                title: "Luggage",
            },
            {
                emoji: "ðŸŒ‚",
                title: "Closed Umbrella",
            },
            {
                emoji: "â˜‚ï¸",
                title: "Umbrella",
            },
            {
                emoji: "ðŸŽƒ",
                title: "Jack-O-Lantern",
            },
            {
                emoji: "ðŸ§µ",
                title: "Thread",
            },
            {
                emoji: "ðŸ§¶",
                title: "Yarn",
            },
            {
                emoji: "ðŸ‘“",
                title: "Glasses",
            },
            {
                emoji: "ðŸ•¶ï¸",
                title: "Sunglasses",
            },
            {
                emoji: "ðŸ¥½",
                title: "Goggles",
            },
            {
                emoji: "ðŸ¥¼",
                title: "Lab Coat",
            },
            {
                emoji: "ðŸ¦º",
                title: "Safety Vest",
            },
            {
                emoji: "ðŸ‘”",
                title: "Necktie",
            },
            {
                emoji: "ðŸ‘•",
                title: "T-Shirt",
            },
            {
                emoji: "ðŸ‘–",
                title: "Jeans",
            },
            {
                emoji: "ðŸ§£",
                title: "Scarf",
            },
            {
                emoji: "ðŸ§¤",
                title: "Gloves",
            },
            {
                emoji: "ðŸ§¥",
                title: "Coat",
            },
            {
                emoji: "ðŸ§¦",
                title: "Socks",
            },
            {
                emoji: "ðŸ‘—",
                title: "Dress",
            },
            {
                emoji: "ðŸ‘˜",
                title: "Kimono",
            },
            {
                emoji: "ðŸ¥»",
                title: "Sari",
            },
            {
                emoji: "ðŸ©±",
                title: "One-Piece Swimsuit",
            },
            {
                emoji: "ðŸ©²",
                title: "Briefs",
            },
            {
                emoji: "ðŸ©³",
                title: "Shorts",
            },
            {
                emoji: "ðŸ‘™",
                title: "Bikini",
            },
            {
                emoji: "ðŸ‘š",
                title: "Womanâ€™s Clothes",
            },
            {
                emoji: "ðŸ‘›",
                title: "Purse",
            },
            {
                emoji: "ðŸ‘œ",
                title: "Handbag",
            },
            {
                emoji: "ðŸ‘",
                title: "Clutch Bag",
            },
            {
                emoji: "ðŸŽ’",
                title: "Backpack",
            },
            {
                emoji: "ðŸ©´",
                title: "Thong Sandal",
            },
            {
                emoji: "ðŸ‘ž",
                title: "Manâ€™s Shoe",
            },
            {
                emoji: "ðŸ‘Ÿ",
                title: "Running Shoe",
            },
            {
                emoji: "ðŸ¥¾",
                title: "Hiking Boot",
            },
            {
                emoji: "ðŸ¥¿",
                title: "Flat Shoe",
            },
            {
                emoji: "ðŸ‘ ",
                title: "High-Heeled Shoe",
            },
            {
                emoji: "ðŸ‘¡",
                title: "Womanâ€™s Sandal",
            },
            {
                emoji: "ðŸ©°",
                title: "Ballet Shoes",
            },
            {
                emoji: "ðŸ‘¢",
                title: "Womanâ€™s Boot",
            },
            {
                emoji: "ðŸ‘‘",
                title: "Crown",
            },
            {
                emoji: "ðŸ‘’",
                title: "Womanâ€™s Hat",
            },
            {
                emoji: "ðŸŽ©",
                title: "Top Hat",
            },
            {
                emoji: "ðŸŽ“",
                title: "Graduation Cap",
            },
            {
                emoji: "ðŸ§¢",
                title: "Billed Cap",
            },
            {
                emoji: "ðŸª–",
                title: "Military Helmet",
            },
            {
                emoji: "â›‘ï¸",
                title: "Rescue Workerâ€™s Helmet",
            },
            {
                emoji: "ðŸ’„",
                title: "Lipstick",
            },
            {
                emoji: "ðŸ’",
                title: "Ring",
            },
            {
                emoji: "ðŸ’¼",
                title: "Briefcase",
            },
            {
                emoji: "ðŸ©¸",
                title: "Drop of Blood",
            },
        ],
        Nature: [
            {
                emoji: "ðŸ™ˆ",
                title: "See-No-Evil Monkey",
            },
            {
                emoji: "ðŸ™‰",
                title: "Hear-No-Evil Monkey",
            },
            {
                emoji: "ðŸ™Š",
                title: "Speak-No-Evil Monkey",
            },
            {
                emoji: "ðŸ’¥",
                title: "Collision",
            },
            {
                emoji: "ðŸ’«",
                title: "Dizzy",
            },
            {
                emoji: "ðŸ’¦",
                title: "Sweat Droplets",
            },
            {
                emoji: "ðŸ’¨",
                title: "Dashing Away",
            },
            {
                emoji: "ðŸµ",
                title: "Monkey Face",
            },
            {
                emoji: "ðŸ’",
                title: "Monkey",
            },
            {
                emoji: "ðŸ¦",
                title: "Gorilla",
            },
            {
                emoji: "ðŸ¦§",
                title: "Orangutan",
            },
            {
                emoji: "ðŸ¶",
                title: "Dog Face",
            },
            {
                emoji: "ðŸ•",
                title: "Dog",
            },
            {
                emoji: "ðŸ¦®",
                title: "Guide Dog",
            },
            {
                emoji: "ðŸ•â€ðŸ¦º",
                title: "Service Dog",
            },
            {
                emoji: "ðŸ©",
                title: "Poodle",
            },
            {
                emoji: "ðŸº",
                title: "Wolf",
            },
            {
                emoji: "ðŸ¦Š",
                title: "Fox",
            },
            {
                emoji: "ðŸ¦",
                title: "Raccoon",
            },
            {
                emoji: "ðŸ±",
                title: "Cat Face",
            },
            {
                emoji: "ðŸˆ",
                title: "Cat",
            },
            {
                emoji: "ðŸˆâ€â¬›",
                title: "Black Cat",
            },
            {
                emoji: "ðŸ¦",
                title: "Lion",
            },
            {
                emoji: "ðŸ¯",
                title: "Tiger Face",
            },
            {
                emoji: "ðŸ…",
                title: "Tiger",
            },
            {
                emoji: "ðŸ†",
                title: "Leopard",
            },
            {
                emoji: "ðŸ´",
                title: "Horse Face",
            },
            {
                emoji: "ðŸŽ",
                title: "Horse",
            },
            {
                emoji: "ðŸ¦„",
                title: "Unicorn",
            },
            {
                emoji: "ðŸ¦“",
                title: "Zebra",
            },
            {
                emoji: "ðŸ¦Œ",
                title: "Deer",
            },
            {
                emoji: "ðŸ¦¬",
                title: "Bison",
            },
            {
                emoji: "ðŸ®",
                title: "Cow Face",
            },
            {
                emoji: "ðŸ‚",
                title: "Ox",
            },
            {
                emoji: "ðŸƒ",
                title: "Water Buffalo",
            },
            {
                emoji: "ðŸ„",
                title: "Cow",
            },
            {
                emoji: "ðŸ·",
                title: "Pig Face",
            },
            {
                emoji: "ðŸ–",
                title: "Pig",
            },
            {
                emoji: "ðŸ—",
                title: "Boar",
            },
            {
                emoji: "ðŸ½",
                title: "Pig Nose",
            },
            {
                emoji: "ðŸ",
                title: "Ram",
            },
            {
                emoji: "ðŸ‘",
                title: "Ewe",
            },
            {
                emoji: "ðŸ",
                title: "Goat",
            },
            {
                emoji: "ðŸª",
                title: "Camel",
            },
            {
                emoji: "ðŸ«",
                title: "Two-Hump Camel",
            },
            {
                emoji: "ðŸ¦™",
                title: "Llama",
            },
            {
                emoji: "ðŸ¦’",
                title: "Giraffe",
            },
            {
                emoji: "ðŸ˜",
                title: "Elephant",
            },
            {
                emoji: "ðŸ¦£",
                title: "Mammoth",
            },
            {
                emoji: "ðŸ¦",
                title: "Rhinoceros",
            },
            {
                emoji: "ðŸ¦›",
                title: "Hippopotamus",
            },
            {
                emoji: "ðŸ­",
                title: "Mouse Face",
            },
            {
                emoji: "ðŸ",
                title: "Mouse",
            },
            {
                emoji: "ðŸ€",
                title: "Rat",
            },
            {
                emoji: "ðŸ¹",
                title: "Hamster",
            },
            {
                emoji: "ðŸ°",
                title: "Rabbit Face",
            },
            {
                emoji: "ðŸ‡",
                title: "Rabbit",
            },
            {
                emoji: "ðŸ¿ï¸",
                title: "Chipmunk",
            },
            {
                emoji: "ðŸ¦«",
                title: "Beaver",
            },
            {
                emoji: "ðŸ¦”",
                title: "Hedgehog",
            },
            {
                emoji: "ðŸ¦‡",
                title: "Bat",
            },
            {
                emoji: "ðŸ»",
                title: "Bear",
            },
            {
                emoji: "ðŸ»â€â„ï¸",
                title: "Polar Bear",
            },
            {
                emoji: "ðŸ¨",
                title: "Koala",
            },
            {
                emoji: "ðŸ¼",
                title: "Panda",
            },
            {
                emoji: "ðŸ¦¥",
                title: "Sloth",
            },
            {
                emoji: "ðŸ¦¦",
                title: "Otter",
            },
            {
                emoji: "ðŸ¦¨",
                title: "Skunk",
            },
            {
                emoji: "ðŸ¦˜",
                title: "Kangaroo",
            },
            {
                emoji: "ðŸ¦¡",
                title: "Badger",
            },
            {
                emoji: "ðŸ¾",
                title: "Paw Prints",
            },
            {
                emoji: "ðŸ¦ƒ",
                title: "Turkey",
            },
            {
                emoji: "ðŸ”",
                title: "Chicken",
            },
            {
                emoji: "ðŸ“",
                title: "Rooster",
            },
            {
                emoji: "ðŸ£",
                title: "Hatching Chick",
            },
            {
                emoji: "ðŸ¤",
                title: "Baby Chick",
            },
            {
                emoji: "ðŸ¥",
                title: "Front-Facing Baby Chick",
            },
            {
                emoji: "ðŸ¦",
                title: "Bird",
            },
            {
                emoji: "ðŸ§",
                title: "Penguin",
            },
            {
                emoji: "ðŸ•Šï¸",
                title: "Dove",
            },
            {
                emoji: "ðŸ¦…",
                title: "Eagle",
            },
            {
                emoji: "ðŸ¦†",
                title: "Duck",
            },
            {
                emoji: "ðŸ¦¢",
                title: "Swan",
            },
            {
                emoji: "ðŸ¦‰",
                title: "Owl",
            },
            {
                emoji: "ðŸ¦¤",
                title: "Dodo",
            },
            {
                emoji: "ðŸª¶",
                title: "Feather",
            },
            {
                emoji: "ðŸ¦©",
                title: "Flamingo",
            },
            {
                emoji: "ðŸ¦š",
                title: "Peacock",
            },
            {
                emoji: "ðŸ¦œ",
                title: "Parrot",
            },
            {
                emoji: "ðŸ¸",
                title: "Frog",
            },
            {
                emoji: "ðŸŠ",
                title: "Crocodile",
            },
            {
                emoji: "ðŸ¢",
                title: "Turtle",
            },
            {
                emoji: "ðŸ¦Ž",
                title: "Lizard",
            },
            {
                emoji: "ðŸ",
                title: "Snake",
            },
            {
                emoji: "ðŸ²",
                title: "Dragon Face",
            },
            {
                emoji: "ðŸ‰",
                title: "Dragon",
            },
            {
                emoji: "ðŸ¦•",
                title: "Sauropod",
            },
            {
                emoji: "ðŸ¦–",
                title: "T-Rex",
            },
            {
                emoji: "ðŸ³",
                title: "Spouting Whale",
            },
            {
                emoji: "ðŸ‹",
                title: "Whale",
            },
            {
                emoji: "ðŸ¬",
                title: "Dolphin",
            },
            {
                emoji: "ðŸ¦­",
                title: "Seal",
            },
            {
                emoji: "ðŸŸ",
                title: "Fish",
            },
            {
                emoji: "ðŸ ",
                title: "Tropical Fish",
            },
            {
                emoji: "ðŸ¡",
                title: "Blowfish",
            },
            {
                emoji: "ðŸ¦ˆ",
                title: "Shark",
            },
            {
                emoji: "ðŸ™",
                title: "Octopus",
            },
            {
                emoji: "ðŸš",
                title: "Spiral Shell",
            },
            {
                emoji: "ðŸŒ",
                title: "Snail",
            },
            {
                emoji: "ðŸ¦‹",
                title: "Butterfly",
            },
            {
                emoji: "ðŸ›",
                title: "Bug",
            },
            {
                emoji: "ðŸœ",
                title: "Ant",
            },
            {
                emoji: "ðŸ",
                title: "Honeybee",
            },
            {
                emoji: "ðŸª²",
                title: "Beetle",
            },
            {
                emoji: "ðŸž",
                title: "Lady Beetle",
            },
            {
                emoji: "ðŸ¦—",
                title: "Cricket",
            },
            {
                emoji: "ðŸª³",
                title: "Cockroach",
            },
            {
                emoji: "ðŸ•·ï¸",
                title: "Spider",
            },
            {
                emoji: "ðŸ•¸ï¸",
                title: "Spider Web",
            },
            {
                emoji: "ðŸ¦‚",
                title: "Scorpion",
            },
            {
                emoji: "ðŸ¦Ÿ",
                title: "Mosquito",
            },
            {
                emoji: "ðŸª°",
                title: "Fly",
            },
            {
                emoji: "ðŸª±",
                title: "Worm",
            },
            {
                emoji: "ðŸ¦ ",
                title: "Microbe",
            },
            {
                emoji: "ðŸ’",
                title: "Bouquet",
            },
            {
                emoji: "ðŸŒ¸",
                title: "Cherry Blossom",
            },
            {
                emoji: "ðŸ’®",
                title: "White Flower",
            },
            {
                emoji: "ðŸµï¸",
                title: "Rosette",
            },
            {
                emoji: "ðŸŒ¹",
                title: "Rose",
            },
            {
                emoji: "ðŸ¥€",
                title: "Wilted Flower",
            },
            {
                emoji: "ðŸŒº",
                title: "Hibiscus",
            },
            {
                emoji: "ðŸŒ»",
                title: "Sunflower",
            },
            {
                emoji: "ðŸŒ¼",
                title: "Blossom",
            },
            {
                emoji: "ðŸŒ·",
                title: "Tulip",
            },
            {
                emoji: "ðŸŒ±",
                title: "Seedling",
            },
            {
                emoji: "ðŸª´",
                title: "Potted Plant",
            },
            {
                emoji: "ðŸŒ²",
                title: "Evergreen Tree",
            },
            {
                emoji: "ðŸŒ³",
                title: "Deciduous Tree",
            },
            {
                emoji: "ðŸŒ´",
                title: "Palm Tree",
            },
            {
                emoji: "ðŸŒµ",
                title: "Cactus",
            },
            {
                emoji: "ðŸŒ¾",
                title: "Sheaf of Rice",
            },
            {
                emoji: "ðŸŒ¿",
                title: "Herb",
            },
            {
                emoji: "â˜˜ï¸",
                title: "Shamrock",
            },
            {
                emoji: "ðŸ€",
                title: "Four Leaf Clover",
            },
            {
                emoji: "ðŸ",
                title: "Maple Leaf",
            },
            {
                emoji: "ðŸ‚",
                title: "Fallen Leaf",
            },
            {
                emoji: "ðŸƒ",
                title: "Leaf Fluttering in Wind",
            },
            {
                emoji: "ðŸ„",
                title: "Mushroom",
            },
            {
                emoji: "ðŸŒ°",
                title: "Chestnut",
            },
            {
                emoji: "ðŸ¦€",
                title: "Crab",
            },
            {
                emoji: "ðŸ¦ž",
                title: "Lobster",
            },
            {
                emoji: "ðŸ¦",
                title: "Shrimp",
            },
            {
                emoji: "ðŸ¦‘",
                title: "Squid",
            },
            {
                emoji: "ðŸŒ",
                title: "Globe Showing Europe-Africa",
            },
            {
                emoji: "ðŸŒŽ",
                title: "Globe Showing Americas",
            },
            {
                emoji: "ðŸŒ",
                title: "Globe Showing Asia-Australia",
            },
            {
                emoji: "ðŸŒ",
                title: "Globe with Meridians",
            },
            {
                emoji: "ðŸª¨",
                title: "Rock",
            },
            {
                emoji: "ðŸŒ‘",
                title: "New Moon",
            },
            {
                emoji: "ðŸŒ’",
                title: "Waxing Crescent Moon",
            },
            {
                emoji: "ðŸŒ“",
                title: "First Quarter Moon",
            },
            {
                emoji: "ðŸŒ”",
                title: "Waxing Gibbous Moon",
            },
            {
                emoji: "ðŸŒ•",
                title: "Full Moon",
            },
            {
                emoji: "ðŸŒ–",
                title: "Waning Gibbous Moon",
            },
            {
                emoji: "ðŸŒ—",
                title: "Last Quarter Moon",
            },
            {
                emoji: "ðŸŒ˜",
                title: "Waning Crescent Moon",
            },
            {
                emoji: "ðŸŒ™",
                title: "Crescent Moon",
            },
            {
                emoji: "ðŸŒš",
                title: "New Moon Face",
            },
            {
                emoji: "ðŸŒ›",
                title: "First Quarter Moon Face",
            },
            {
                emoji: "ðŸŒœ",
                title: "Last Quarter Moon Face",
            },
            {
                emoji: "â˜€ï¸",
                title: "Sun",
            },
            {
                emoji: "ðŸŒ",
                title: "Full Moon Face",
            },
            {
                emoji: "ðŸŒž",
                title: "Sun with Face",
            },
            {
                emoji: "â­",
                title: "Star",
            },
            {
                emoji: "ðŸŒŸ",
                title: "Glowing Star",
            },
            {
                emoji: "ðŸŒ ",
                title: "Shooting Star",
            },
            {
                emoji: "â˜ï¸",
                title: "Cloud",
            },
            {
                emoji: "â›…",
                title: "Sun Behind Cloud",
            },
            {
                emoji: "â›ˆï¸",
                title: "Cloud with Lightning and Rain",
            },
            {
                emoji: "ðŸŒ¤ï¸",
                title: "Sun Behind Small Cloud",
            },
            {
                emoji: "ðŸŒ¥ï¸",
                title: "Sun Behind Large Cloud",
            },
            {
                emoji: "ðŸŒ¦ï¸",
                title: "Sun Behind Rain Cloud",
            },
            {
                emoji: "ðŸŒ§ï¸",
                title: "Cloud with Rain",
            },
            {
                emoji: "ðŸŒ¨ï¸",
                title: "Cloud with Snow",
            },
            {
                emoji: "ðŸŒ©ï¸",
                title: "Cloud with Lightning",
            },
            {
                emoji: "ðŸŒªï¸",
                title: "Tornado",
            },
            {
                emoji: "ðŸŒ«ï¸",
                title: "Fog",
            },
            {
                emoji: "ðŸŒ¬ï¸",
                title: "Wind Face",
            },
            {
                emoji: "ðŸŒˆ",
                title: "Rainbow",
            },
            {
                emoji: "â˜‚ï¸",
                title: "Umbrella",
            },
            {
                emoji: "â˜”",
                title: "Umbrella with Rain Drops",
            },
            {
                emoji: "âš¡",
                title: "High Voltage",
            },
            {
                emoji: "â„ï¸",
                title: "Snowflake",
            },
            {
                emoji: "â˜ƒï¸",
                title: "Snowman",
            },
            {
                emoji: "â›„",
                title: "Snowman Without Snow",
            },
            {
                emoji: "â˜„ï¸",
                title: "Comet",
            },
            {
                emoji: "ðŸ”¥",
                title: "Fire",
            },
            {
                emoji: "ðŸ’§",
                title: "Droplet",
            },
            {
                emoji: "ðŸŒŠ",
                title: "Water Wave",
            },
            {
                emoji: "ðŸŽ„",
                title: "Christmas Tree",
            },
            {
                emoji: "âœ¨",
                title: "Sparkles",
            },
            {
                emoji: "ðŸŽ‹",
                title: "Tanabata Tree",
            },
            {
                emoji: "ðŸŽ",
                title: "Pine Decoration",
            },
        ],
        "Food-dring": [
            {
                emoji: "ðŸ‡",
                title: "Grapes",
            },
            {
                emoji: "ðŸˆ",
                title: "Melon",
            },
            {
                emoji: "ðŸ‰",
                title: "Watermelon",
            },
            {
                emoji: "ðŸŠ",
                title: "Tangerine",
            },
            {
                emoji: "ðŸ‹",
                title: "Lemon",
            },
            {
                emoji: "ðŸŒ",
                title: "Banana",
            },
            {
                emoji: "ðŸ",
                title: "Pineapple",
            },
            {
                emoji: "ðŸ¥­",
                title: "Mango",
            },
            {
                emoji: "ðŸŽ",
                title: "Red Apple",
            },
            {
                emoji: "ðŸ",
                title: "Green Apple",
            },
            {
                emoji: "ðŸ",
                title: "Pear",
            },
            {
                emoji: "ðŸ‘",
                title: "Peach",
            },
            {
                emoji: "ðŸ’",
                title: "Cherries",
            },
            {
                emoji: "ðŸ“",
                title: "Strawberry",
            },
            {
                emoji: "ðŸ«",
                title: "Blueberries",
            },
            {
                emoji: "ðŸ¥",
                title: "Kiwi Fruit",
            },
            {
                emoji: "ðŸ…",
                title: "Tomato",
            },
            {
                emoji: "ðŸ«’",
                title: "Olive",
            },
            {
                emoji: "ðŸ¥¥",
                title: "Coconut",
            },
            {
                emoji: "ðŸ¥‘",
                title: "Avocado",
            },
            {
                emoji: "ðŸ†",
                title: "Eggplant",
            },
            {
                emoji: "ðŸ¥”",
                title: "Potato",
            },
            {
                emoji: "ðŸ¥•",
                title: "Carrot",
            },
            {
                emoji: "ðŸŒ½",
                title: "Ear of Corn",
            },
            {
                emoji: "ðŸŒ¶ï¸",
                title: "Hot Pepper",
            },
            {
                emoji: "ðŸ«‘",
                title: "Bell Pepper",
            },
            {
                emoji: "ðŸ¥’",
                title: "Cucumber",
            },
            {
                emoji: "ðŸ¥¬",
                title: "Leafy Green",
            },
            {
                emoji: "ðŸ¥¦",
                title: "Broccoli",
            },
            {
                emoji: "ðŸ§„",
                title: "Garlic",
            },
            {
                emoji: "ðŸ§…",
                title: "Onion",
            },
            {
                emoji: "ðŸ„",
                title: "Mushroom",
            },
            {
                emoji: "ðŸ¥œ",
                title: "Peanuts",
            },
            {
                emoji: "ðŸŒ°",
                title: "Chestnut",
            },
            {
                emoji: "ðŸž",
                title: "Bread",
            },
            {
                emoji: "ðŸ¥",
                title: "Croissant",
            },
            {
                emoji: "ðŸ¥–",
                title: "Baguette Bread",
            },
            {
                emoji: "ðŸ«“",
                title: "Flatbread",
            },
            {
                emoji: "ðŸ¥¨",
                title: "Pretzel",
            },
            {
                emoji: "ðŸ¥¯",
                title: "Bagel",
            },
            {
                emoji: "ðŸ¥ž",
                title: "Pancakes",
            },
            {
                emoji: "ðŸ§‡",
                title: "Waffle",
            },
            {
                emoji: "ðŸ§€",
                title: "Cheese Wedge",
            },
            {
                emoji: "ðŸ–",
                title: "Meat on Bone",
            },
            {
                emoji: "ðŸ—",
                title: "Poultry Leg",
            },
            {
                emoji: "ðŸ¥©",
                title: "Cut of Meat",
            },
            {
                emoji: "ðŸ¥“",
                title: "Bacon",
            },
            {
                emoji: "ðŸ”",
                title: "Hamburger",
            },
            {
                emoji: "ðŸŸ",
                title: "French Fries",
            },
            {
                emoji: "ðŸ•",
                title: "Pizza",
            },
            {
                emoji: "ðŸŒ­",
                title: "Hot Dog",
            },
            {
                emoji: "ðŸ¥ª",
                title: "Sandwich",
            },
            {
                emoji: "ðŸŒ®",
                title: "Taco",
            },
            {
                emoji: "ðŸŒ¯",
                title: "Burrito",
            },
            {
                emoji: "ðŸ«”",
                title: "Tamale",
            },
            {
                emoji: "ðŸ¥™",
                title: "Stuffed Flatbread",
            },
            {
                emoji: "ðŸ§†",
                title: "Falafel",
            },
            {
                emoji: "ðŸ¥š",
                title: "Egg",
            },
            {
                emoji: "ðŸ³",
                title: "Cooking",
            },
            {
                emoji: "ðŸ¥˜",
                title: "Shallow Pan of Food",
            },
            {
                emoji: "ðŸ²",
                title: "Pot of Food",
            },
            {
                emoji: "ðŸ«•",
                title: "Fondue",
            },
            {
                emoji: "ðŸ¥£",
                title: "Bowl with Spoon",
            },
            {
                emoji: "ðŸ¥—",
                title: "Green Salad",
            },
            {
                emoji: "ðŸ¿",
                title: "Popcorn",
            },
            {
                emoji: "ðŸ§ˆ",
                title: "Butter",
            },
            {
                emoji: "ðŸ§‚",
                title: "Salt",
            },
            {
                emoji: "ðŸ¥«",
                title: "Canned Food",
            },
            {
                emoji: "ðŸ±",
                title: "Bento Box",
            },
            {
                emoji: "ðŸ˜",
                title: "Rice Cracker",
            },
            {
                emoji: "ðŸ™",
                title: "Rice Ball",
            },
            {
                emoji: "ðŸš",
                title: "Cooked Rice",
            },
            {
                emoji: "ðŸ›",
                title: "Curry Rice",
            },
            {
                emoji: "ðŸœ",
                title: "Steaming Bowl",
            },
            {
                emoji: "ðŸ",
                title: "Spaghetti",
            },
            {
                emoji: "ðŸ ",
                title: "Roasted Sweet Potato",
            },
            {
                emoji: "ðŸ¢",
                title: "Oden",
            },
            {
                emoji: "ðŸ£",
                title: "Sushi",
            },
            {
                emoji: "ðŸ¤",
                title: "Fried Shrimp",
            },
            {
                emoji: "ðŸ¥",
                title: "Fish Cake with Swirl",
            },
            {
                emoji: "ðŸ¥®",
                title: "Moon Cake",
            },
            {
                emoji: "ðŸ¡",
                title: "Dango",
            },
            {
                emoji: "ðŸ¥Ÿ",
                title: "Dumpling",
            },
            {
                emoji: "ðŸ¥ ",
                title: "Fortune Cookie",
            },
            {
                emoji: "ðŸ¥¡",
                title: "Takeout Box",
            },
            {
                emoji: "ðŸ¦ª",
                title: "Oyster",
            },
            {
                emoji: "ðŸ¦",
                title: "Soft Ice Cream",
            },
            {
                emoji: "ðŸ§",
                title: "Shaved Ice",
            },
            {
                emoji: "ðŸ¨",
                title: "Ice Cream",
            },
            {
                emoji: "ðŸ©",
                title: "Doughnut",
            },
            {
                emoji: "ðŸª",
                title: "Cookie",
            },
            {
                emoji: "ðŸŽ‚",
                title: "Birthday Cake",
            },
            {
                emoji: "ðŸ°",
                title: "Shortcake",
            },
            {
                emoji: "ðŸ§",
                title: "Cupcake",
            },
            {
                emoji: "ðŸ¥§",
                title: "Pie",
            },
            {
                emoji: "ðŸ«",
                title: "Chocolate Bar",
            },
            {
                emoji: "ðŸ¬",
                title: "Candy",
            },
            {
                emoji: "ðŸ­",
                title: "Lollipop",
            },
            {
                emoji: "ðŸ®",
                title: "Custard",
            },
            {
                emoji: "ðŸ¯",
                title: "Honey Pot",
            },
            {
                emoji: "ðŸ¼",
                title: "Baby Bottle",
            },
            {
                emoji: "ðŸ¥›",
                title: "Glass of Milk",
            },
            {
                emoji: "â˜•",
                title: "Hot Beverage",
            },
            {
                emoji: "ðŸ«–",
                title: "Teapot",
            },
            {
                emoji: "ðŸµ",
                title: "Teacup Without Handle",
            },
            {
                emoji: "ðŸ¶",
                title: "Sake",
            },
            {
                emoji: "ðŸ¾",
                title: "Bottle with Popping Cork",
            },
            {
                emoji: "ðŸ·",
                title: "Wine Glass",
            },
            {
                emoji: "ðŸ¸",
                title: "Cocktail Glass",
            },
            {
                emoji: "ðŸ¹",
                title: "Tropical Drink",
            },
            {
                emoji: "ðŸº",
                title: "Beer Mug",
            },
            {
                emoji: "ðŸ»",
                title: "Clinking Beer Mugs",
            },
            {
                emoji: "ðŸ¥‚",
                title: "Clinking Glasses",
            },
            {
                emoji: "ðŸ¥ƒ",
                title: "Tumbler Glass",
            },
            {
                emoji: "ðŸ¥¤",
                title: "Cup with Straw",
            },
            {
                emoji: "ðŸ§‹",
                title: "Bubble Tea",
            },
            {
                emoji: "ðŸ§ƒ",
                title: "Beverage Box",
            },
            {
                emoji: "ðŸ§‰",
                title: "Mate",
            },
            {
                emoji: "ðŸ§Š",
                title: "Ice",
            },
            {
                emoji: "ðŸ¥¢",
                title: "Chopsticks",
            },
            {
                emoji: "ðŸ½ï¸",
                title: "Fork and Knife with Plate",
            },
            {
                emoji: "ðŸ´",
                title: "Fork and Knife",
            },
            {
                emoji: "ðŸ¥„",
                title: "Spoon",
            },
        ],
        Activity: [
            {
                emoji: "ðŸ•´ï¸",
                title: "Person in Suit Levitating",
            },
            {
                emoji: "ðŸ§—",
                title: "Person Climbing",
            },
            {
                emoji: "ðŸ§—â€â™‚ï¸",
                title: "Man Climbing",
            },
            {
                emoji: "ðŸ§—â€â™€ï¸",
                title: "Woman Climbing",
            },
            {
                emoji: "ðŸ¤º",
                title: "Person Fencing",
            },
            {
                emoji: "ðŸ‡",
                title: "Horse Racing",
            },
            {
                emoji: "â›·ï¸",
                title: "Skier",
            },
            {
                emoji: "ðŸ‚",
                title: "Snowboarder",
            },
            {
                emoji: "ðŸŒï¸",
                title: "Person Golfing",
            },
            {
                emoji: "ðŸŒï¸â€â™‚ï¸",
                title: "Man Golfing",
            },
            {
                emoji: "ðŸŒï¸â€â™€ï¸",
                title: "Woman Golfing",
            },
            {
                emoji: "ðŸ„",
                title: "Person Surfing",
            },
            {
                emoji: "ðŸ„â€â™‚ï¸",
                title: "Man Surfing",
            },
            {
                emoji: "ðŸ„â€â™€ï¸",
                title: "Woman Surfing",
            },
            {
                emoji: "ðŸš£",
                title: "Person Rowing Boat",
            },
            {
                emoji: "ðŸš£â€â™‚ï¸",
                title: "Man Rowing Boat",
            },
            {
                emoji: "ðŸš£â€â™€ï¸",
                title: "Woman Rowing Boat",
            },
            {
                emoji: "ðŸŠ",
                title: "Person Swimming",
            },
            {
                emoji: "ðŸŠâ€â™‚ï¸",
                title: "Man Swimming",
            },
            {
                emoji: "ðŸŠâ€â™€ï¸",
                title: "Woman Swimming",
            },
            {
                emoji: "â›¹ï¸",
                title: "Person Bouncing Ball",
            },
            {
                emoji: "â›¹ï¸â€â™‚ï¸",
                title: "Man Bouncing Ball",
            },
            {
                emoji: "â›¹ï¸â€â™€ï¸",
                title: "Woman Bouncing Ball",
            },
            {
                emoji: "ðŸ‹ï¸",
                title: "Person Lifting Weights",
            },
            {
                emoji: "ðŸ‹ï¸â€â™‚ï¸",
                title: "Man Lifting Weights",
            },
            {
                emoji: "ðŸ‹ï¸â€â™€ï¸",
                title: "Woman Lifting Weights",
            },
            {
                emoji: "ðŸš´",
                title: "Person Biking",
            },
            {
                emoji: "ðŸš´â€â™‚ï¸",
                title: "Man Biking",
            },
            {
                emoji: "ðŸš´â€â™€ï¸",
                title: "Woman Biking",
            },
            {
                emoji: "ðŸšµ",
                title: "Person Mountain Biking",
            },
            {
                emoji: "ðŸšµâ€â™‚ï¸",
                title: "Man Mountain Biking",
            },
            {
                emoji: "ðŸšµâ€â™€ï¸",
                title: "Woman Mountain Biking",
            },
            {
                emoji: "ðŸ¤¸",
                title: "Person Cartwheeling",
            },
            {
                emoji: "ðŸ¤¸â€â™‚ï¸",
                title: "Man Cartwheeling",
            },
            {
                emoji: "ðŸ¤¸â€â™€ï¸",
                title: "Woman Cartwheeling",
            },
            {
                emoji: "ðŸ¤¼",
                title: "People Wrestling",
            },
            {
                emoji: "ðŸ¤¼â€â™‚ï¸",
                title: "Men Wrestling",
            },
            {
                emoji: "ðŸ¤¼â€â™€ï¸",
                title: "Women Wrestling",
            },
            {
                emoji: "ðŸ¤½",
                title: "Person Playing Water Polo",
            },
            {
                emoji: "ðŸ¤½â€â™‚ï¸",
                title: "Man Playing Water Polo",
            },
            {
                emoji: "ðŸ¤½â€â™€ï¸",
                title: "Woman Playing Water Polo",
            },
            {
                emoji: "ðŸ¤¾",
                title: "Person Playing Handball",
            },
            {
                emoji: "ðŸ¤¾â€â™‚ï¸",
                title: "Man Playing Handball",
            },
            {
                emoji: "ðŸ¤¾â€â™€ï¸",
                title: "Woman Playing Handball",
            },
            {
                emoji: "ðŸ¤¹",
                title: "Person Juggling",
            },
            {
                emoji: "ðŸ¤¹â€â™‚ï¸",
                title: "Man Juggling",
            },
            {
                emoji: "ðŸ¤¹â€â™€ï¸",
                title: "Woman Juggling",
            },
            {
                emoji: "ðŸ§˜",
                title: "Person in Lotus Position",
            },
            {
                emoji: "ðŸ§˜â€â™‚ï¸",
                title: "Man in Lotus Position",
            },
            {
                emoji: "ðŸ§˜â€â™€ï¸",
                title: "Woman in Lotus Position",
            },
            {
                emoji: "ðŸŽª",
                title: "Circus Tent",
            },
            {
                emoji: "ðŸ›¹",
                title: "Skateboard",
            },
            {
                emoji: "ðŸ›¼",
                title: "Roller Skate",
            },
            {
                emoji: "ðŸ›¶",
                title: "Canoe",
            },
            {
                emoji: "ðŸŽ—ï¸",
                title: "Reminder Ribbon",
            },
            {
                emoji: "ðŸŽŸï¸",
                title: "Admission Tickets",
            },
            {
                emoji: "ðŸŽ«",
                title: "Ticket",
            },
            {
                emoji: "ðŸŽ–ï¸",
                title: "Military Medal",
            },
            {
                emoji: "ðŸ†",
                title: "Trophy",
            },
            {
                emoji: "ðŸ…",
                title: "Sports Medal",
            },
            {
                emoji: "ðŸ¥‡",
                title: "1st Place Medal",
            },
            {
                emoji: "ðŸ¥ˆ",
                title: "2nd Place Medal",
            },
            {
                emoji: "ðŸ¥‰",
                title: "3rd Place Medal",
            },
            {
                emoji: "âš½",
                title: "Soccer Ball",
            },
            {
                emoji: "âš¾",
                title: "Baseball",
            },
            {
                emoji: "ðŸ¥Ž",
                title: "Softball",
            },
            {
                emoji: "ðŸ€",
                title: "Basketball",
            },
            {
                emoji: "ðŸ",
                title: "Volleyball",
            },
            {
                emoji: "ðŸˆ",
                title: "American Football",
            },
            {
                emoji: "ðŸ‰",
                title: "Rugby Football",
            },
            {
                emoji: "ðŸŽ¾",
                title: "Tennis",
            },
            {
                emoji: "ðŸ¥",
                title: "Flying Disc",
            },
            {
                emoji: "ðŸŽ³",
                title: "Bowling",
            },
            {
                emoji: "ðŸ",
                title: "Cricket Game",
            },
            {
                emoji: "ðŸ‘",
                title: "Field Hockey",
            },
            {
                emoji: "ðŸ’",
                title: "Ice Hockey",
            },
            {
                emoji: "ðŸ¥",
                title: "Lacrosse",
            },
            {
                emoji: "ðŸ“",
                title: "Ping Pong",
            },
            {
                emoji: "ðŸ¸",
                title: "Badminton",
            },
            {
                emoji: "ðŸ¥Š",
                title: "Boxing Glove",
            },
            {
                emoji: "ðŸ¥‹",
                title: "Martial Arts Uniform",
            },
            {
                emoji: "ðŸ¥…",
                title: "Goal Net",
            },
            {
                emoji: "â›³",
                title: "Flag in Hole",
            },
            {
                emoji: "â›¸ï¸",
                title: "Ice Skate",
            },
            {
                emoji: "ðŸŽ£",
                title: "Fishing Pole",
            },
            {
                emoji: "ðŸŽ½",
                title: "Running Shirt",
            },
            {
                emoji: "ðŸŽ¿",
                title: "Skis",
            },
            {
                emoji: "ðŸ›·",
                title: "Sled",
            },
            {
                emoji: "ðŸ¥Œ",
                title: "Curling Stone",
            },
            {
                emoji: "ðŸŽ¯",
                title: "Bullseye",
            },
            {
                emoji: "ðŸŽ±",
                title: "Pool 8 Ball",
            },
            {
                emoji: "ðŸŽ®",
                title: "Video Game",
            },
            {
                emoji: "ðŸŽ°",
                title: "Slot Machine",
            },
            {
                emoji: "ðŸŽ²",
                title: "Game Die",
            },
            {
                emoji: "ðŸ§©",
                title: "Puzzle Piece",
            },
            {
                emoji: "â™Ÿï¸",
                title: "Chess Pawn",
            },
            {
                emoji: "ðŸŽ­",
                title: "Performing Arts",
            },
            {
                emoji: "ðŸŽ¨",
                title: "Artist Palette",
            },
            {
                emoji: "ðŸ§µ",
                title: "Thread",
            },
            {
                emoji: "ðŸ§¶",
                title: "Yarn",
            },
            {
                emoji: "ðŸŽ¼",
                title: "Musical Score",
            },
            {
                emoji: "ðŸŽ¤",
                title: "Microphone",
            },
            {
                emoji: "ðŸŽ§",
                title: "Headphone",
            },
            {
                emoji: "ðŸŽ·",
                title: "Saxophone",
            },
            {
                emoji: "ðŸª—",
                title: "Accordion",
            },
            {
                emoji: "ðŸŽ¸",
                title: "Guitar",
            },
            {
                emoji: "ðŸŽ¹",
                title: "Musical Keyboard",
            },
            {
                emoji: "ðŸŽº",
                title: "Trumpet",
            },
            {
                emoji: "ðŸŽ»",
                title: "Violin",
            },
            {
                emoji: "ðŸ¥",
                title: "Drum",
            },
            {
                emoji: "ðŸª˜",
                title: "Long Drum",
            },
            {
                emoji: "ðŸŽ¬",
                title: "Clapper Board",
            },
            {
                emoji: "ðŸ¹",
                title: "Bow and Arrow",
            },
        ],
        "Travel-places": [
            {
                emoji: "ðŸš£",
                title: "Person Rowing Boat",
            },
            {
                emoji: "ðŸ—¾",
                title: "Map of Japan",
            },
            {
                emoji: "ðŸ”ï¸",
                title: "Snow-Capped Mountain",
            },
            {
                emoji: "â›°ï¸",
                title: "Mountain",
            },
            {
                emoji: "ðŸŒ‹",
                title: "Volcano",
            },
            {
                emoji: "ðŸ—»",
                title: "Mount Fuji",
            },
            {
                emoji: "ðŸ•ï¸",
                title: "Camping",
            },
            {
                emoji: "ðŸ–ï¸",
                title: "Beach with Umbrella",
            },
            {
                emoji: "ðŸœï¸",
                title: "Desert",
            },
            {
                emoji: "ðŸï¸",
                title: "Desert Island",
            },
            {
                emoji: "ðŸžï¸",
                title: "National Park",
            },
            {
                emoji: "ðŸŸï¸",
                title: "Stadium",
            },
            {
                emoji: "ðŸ›ï¸",
                title: "Classical Building",
            },
            {
                emoji: "ðŸ—ï¸",
                title: "Building Construction",
            },
            {
                emoji: "ðŸ›–",
                title: "Hut",
            },
            {
                emoji: "ðŸ˜ï¸",
                title: "Houses",
            },
            {
                emoji: "ðŸšï¸",
                title: "Derelict House",
            },
            {
                emoji: "ðŸ ",
                title: "House",
            },
            {
                emoji: "ðŸ¡",
                title: "House with Garden",
            },
            {
                emoji: "ðŸ¢",
                title: "Office Building",
            },
            {
                emoji: "ðŸ£",
                title: "Japanese Post Office",
            },
            {
                emoji: "ðŸ¤",
                title: "Post Office",
            },
            {
                emoji: "ðŸ¥",
                title: "Hospital",
            },
            {
                emoji: "ðŸ¦",
                title: "Bank",
            },
            {
                emoji: "ðŸ¨",
                title: "Hotel",
            },
            {
                emoji: "ðŸ©",
                title: "Love Hotel",
            },
            {
                emoji: "ðŸª",
                title: "Convenience Store",
            },
            {
                emoji: "ðŸ«",
                title: "School",
            },
            {
                emoji: "ðŸ¬",
                title: "Department Store",
            },
            {
                emoji: "ðŸ­",
                title: "Factory",
            },
            {
                emoji: "ðŸ¯",
                title: "Japanese Castle",
            },
            {
                emoji: "ðŸ°",
                title: "Castle",
            },
            {
                emoji: "ðŸ’’",
                title: "Wedding",
            },
            {
                emoji: "ðŸ—¼",
                title: "Tokyo Tower",
            },
            {
                emoji: "ðŸ—½",
                title: "Statue of Liberty",
            },
            {
                emoji: "â›ª",
                title: "Church",
            },
            {
                emoji: "ðŸ•Œ",
                title: "Mosque",
            },
            {
                emoji: "ðŸ›•",
                title: "Hindu Temple",
            },
            {
                emoji: "ðŸ•",
                title: "Synagogue",
            },
            {
                emoji: "â›©ï¸",
                title: "Shinto Shrine",
            },
            {
                emoji: "ðŸ•‹",
                title: "Kaaba",
            },
            {
                emoji: "â›²",
                title: "Fountain",
            },
            {
                emoji: "â›º",
                title: "Tent",
            },
            {
                emoji: "ðŸŒ",
                title: "Foggy",
            },
            {
                emoji: "ðŸŒƒ",
                title: "Night with Stars",
            },
            {
                emoji: "ðŸ™ï¸",
                title: "Cityscape",
            },
            {
                emoji: "ðŸŒ„",
                title: "Sunrise Over Mountains",
            },
            {
                emoji: "ðŸŒ…",
                title: "Sunrise",
            },
            {
                emoji: "ðŸŒ†",
                title: "Cityscape at Dusk",
            },
            {
                emoji: "ðŸŒ‡",
                title: "Sunset",
            },
            {
                emoji: "ðŸŒ‰",
                title: "Bridge at Night",
            },
            {
                emoji: "ðŸŽ ",
                title: "Carousel Horse",
            },
            {
                emoji: "ðŸŽ¡",
                title: "Ferris Wheel",
            },
            {
                emoji: "ðŸŽ¢",
                title: "Roller Coaster",
            },
            {
                emoji: "ðŸš‚",
                title: "Locomotive",
            },
            {
                emoji: "ðŸšƒ",
                title: "Railway Car",
            },
            {
                emoji: "ðŸš„",
                title: "High-Speed Train",
            },
            {
                emoji: "ðŸš…",
                title: "Bullet Train",
            },
            {
                emoji: "ðŸš†",
                title: "Train",
            },
            {
                emoji: "ðŸš‡",
                title: "Metro",
            },
            {
                emoji: "ðŸšˆ",
                title: "Light Rail",
            },
            {
                emoji: "ðŸš‰",
                title: "Station",
            },
            {
                emoji: "ðŸšŠ",
                title: "Tram",
            },
            {
                emoji: "ðŸš",
                title: "Monorail",
            },
            {
                emoji: "ðŸšž",
                title: "Mountain Railway",
            },
            {
                emoji: "ðŸš‹",
                title: "Tram Car",
            },
            {
                emoji: "ðŸšŒ",
                title: "Bus",
            },
            {
                emoji: "ðŸš",
                title: "Oncoming Bus",
            },
            {
                emoji: "ðŸšŽ",
                title: "Trolleybus",
            },
            {
                emoji: "ðŸš",
                title: "Minibus",
            },
            {
                emoji: "ðŸš‘",
                title: "Ambulance",
            },
            {
                emoji: "ðŸš’",
                title: "Fire Engine",
            },
            {
                emoji: "ðŸš“",
                title: "Police Car",
            },
            {
                emoji: "ðŸš”",
                title: "Oncoming Police Car",
            },
            {
                emoji: "ðŸš•",
                title: "Taxi",
            },
            {
                emoji: "ðŸš–",
                title: "Oncoming Taxi",
            },
            {
                emoji: "ðŸš—",
                title: "Automobile",
            },
            {
                emoji: "ðŸš˜",
                title: "Oncoming Automobile",
            },
            {
                emoji: "ðŸš™",
                title: "Sport Utility Vehicle",
            },
            {
                emoji: "ðŸ›»",
                title: "Pickup Truck",
            },
            {
                emoji: "ðŸšš",
                title: "Delivery Truck",
            },
            {
                emoji: "ðŸš›",
                title: "Articulated Lorry",
            },
            {
                emoji: "ðŸšœ",
                title: "Tractor",
            },
            {
                emoji: "ðŸŽï¸",
                title: "Racing Car",
            },
            {
                emoji: "ðŸï¸",
                title: "Motorcycle",
            },
            {
                emoji: "ðŸ›µ",
                title: "Motor Scooter",
            },
            {
                emoji: "ðŸ›º",
                title: "Auto Rickshaw",
            },
            {
                emoji: "ðŸš²",
                title: "Bicycle",
            },
            {
                emoji: "ðŸ›´",
                title: "Kick Scooter",
            },
            {
                emoji: "ðŸš",
                title: "Bus Stop",
            },
            {
                emoji: "ðŸ›£ï¸",
                title: "Motorway",
            },
            {
                emoji: "ðŸ›¤ï¸",
                title: "Railway Track",
            },
            {
                emoji: "â›½",
                title: "Fuel Pump",
            },
            {
                emoji: "ðŸš¨",
                title: "Police Car Light",
            },
            {
                emoji: "ðŸš¥",
                title: "Horizontal Traffic Light",
            },
            {
                emoji: "ðŸš¦",
                title: "Vertical Traffic Light",
            },
            {
                emoji: "ðŸš§",
                title: "Construction",
            },
            {
                emoji: "âš“",
                title: "Anchor",
            },
            {
                emoji: "â›µ",
                title: "Sailboat",
            },
            {
                emoji: "ðŸš¤",
                title: "Speedboat",
            },
            {
                emoji: "ðŸ›³ï¸",
                title: "Passenger Ship",
            },
            {
                emoji: "â›´ï¸",
                title: "Ferry",
            },
            {
                emoji: "ðŸ›¥ï¸",
                title: "Motor Boat",
            },
            {
                emoji: "ðŸš¢",
                title: "Ship",
            },
            {
                emoji: "âœˆï¸",
                title: "Airplane",
            },
            {
                emoji: "ðŸ›©ï¸",
                title: "Small Airplane",
            },
            {
                emoji: "ðŸ›«",
                title: "Airplane Departure",
            },
            {
                emoji: "ðŸ›¬",
                title: "Airplane Arrival",
            },
            {
                emoji: "ðŸª‚",
                title: "Parachute",
            },
            {
                emoji: "ðŸ’º",
                title: "Seat",
            },
            {
                emoji: "ðŸš",
                title: "Helicopter",
            },
            {
                emoji: "ðŸšŸ",
                title: "Suspension Railway",
            },
            {
                emoji: "ðŸš ",
                title: "Mountain Cableway",
            },
            {
                emoji: "ðŸš¡",
                title: "Aerial Tramway",
            },
            {
                emoji: "ðŸ›°ï¸",
                title: "Satellite",
            },
            {
                emoji: "ðŸš€",
                title: "Rocket",
            },
            {
                emoji: "ðŸ›¸",
                title: "Flying Saucer",
            },
            {
                emoji: "ðŸª",
                title: "Ringed Planet",
            },
            {
                emoji: "ðŸŒ ",
                title: "Shooting Star",
            },
            {
                emoji: "ðŸŒŒ",
                title: "Milky Way",
            },
            {
                emoji: "â›±ï¸",
                title: "Umbrella on Ground",
            },
            {
                emoji: "ðŸŽ†",
                title: "Fireworks",
            },
            {
                emoji: "ðŸŽ‡",
                title: "Sparkler",
            },
            {
                emoji: "ðŸŽ‘",
                title: "Moon Viewing Ceremony",
            },
            {
                emoji: "ðŸ’´",
                title: "Yen Banknote",
            },
            {
                emoji: "ðŸ’µ",
                title: "Dollar Banknote",
            },
            {
                emoji: "ðŸ’¶",
                title: "Euro Banknote",
            },
            {
                emoji: "ðŸ’·",
                title: "Pound Banknote",
            },
            {
                emoji: "ðŸ—¿",
                title: "Moai",
            },
            {
                emoji: "ðŸ›‚",
                title: "Passport Control",
            },
            {
                emoji: "ðŸ›ƒ",
                title: "Customs",
            },
            {
                emoji: "ðŸ›„",
                title: "Baggage Claim",
            },
            {
                emoji: "ðŸ›…",
                title: "Left Luggage",
            },
        ],
        Objects: [
            {
                emoji: "ðŸ’Œ",
                title: "Love Letter",
            },
            {
                emoji: "ðŸ•³ï¸",
                title: "Hole",
            },
            {
                emoji: "ðŸ’£",
                title: "Bomb",
            },
            {
                emoji: "ðŸ›€",
                title: "Person Taking Bath",
            },
            {
                emoji: "ðŸ›Œ",
                title: "Person in Bed",
            },
            {
                emoji: "ðŸ”ª",
                title: "Kitchen Knife",
            },
            {
                emoji: "ðŸº",
                title: "Amphora",
            },
            {
                emoji: "ðŸ—ºï¸",
                title: "World Map",
            },
            {
                emoji: "ðŸ§­",
                title: "Compass",
            },
            {
                emoji: "ðŸ§±",
                title: "Brick",
            },
            {
                emoji: "ðŸ’ˆ",
                title: "Barber Pole",
            },
            {
                emoji: "ðŸ¦½",
                title: "Manual Wheelchair",
            },
            {
                emoji: "ðŸ¦¼",
                title: "Motorized Wheelchair",
            },
            {
                emoji: "ðŸ›¢ï¸",
                title: "Oil Drum",
            },
            {
                emoji: "ðŸ›Žï¸",
                title: "Bellhop Bell",
            },
            {
                emoji: "ðŸ§³",
                title: "Luggage",
            },
            {
                emoji: "âŒ›",
                title: "Hourglass Done",
            },
            {
                emoji: "â³",
                title: "Hourglass Not Done",
            },
            {
                emoji: "âŒš",
                title: "Watch",
            },
            {
                emoji: "â°",
                title: "Alarm Clock",
            },
            {
                emoji: "â±ï¸",
                title: "Stopwatch",
            },
            {
                emoji: "â²ï¸",
                title: "Timer Clock",
            },
            {
                emoji: "ðŸ•°ï¸",
                title: "Mantelpiece Clock",
            },
            {
                emoji: "ðŸŒ¡ï¸",
                title: "Thermometer",
            },
            {
                emoji: "â›±ï¸",
                title: "Umbrella on Ground",
            },
            {
                emoji: "ðŸ§¨",
                title: "Firecracker",
            },
            {
                emoji: "ðŸŽˆ",
                title: "Balloon",
            },
            {
                emoji: "ðŸŽ‰",
                title: "Party Popper",
            },
            {
                emoji: "ðŸŽŠ",
                title: "Confetti Ball",
            },
            {
                emoji: "ðŸŽŽ",
                title: "Japanese Dolls",
            },
            {
                emoji: "ðŸŽ",
                title: "Carp Streamer",
            },
            {
                emoji: "ðŸŽ",
                title: "Wind Chime",
            },
            {
                emoji: "ðŸ§§",
                title: "Red Envelope",
            },
            {
                emoji: "ðŸŽ€",
                title: "Ribbon",
            },
            {
                emoji: "ðŸŽ",
                title: "Wrapped Gift",
            },
            {
                emoji: "ðŸ¤¿",
                title: "Diving Mask",
            },
            {
                emoji: "ðŸª€",
                title: "Yo-Yo",
            },
            {
                emoji: "ðŸª",
                title: "Kite",
            },
            {
                emoji: "ðŸ”®",
                title: "Crystal Ball",
            },
            {
                emoji: "ðŸª„",
                title: "Magic Wand",
            },
            {
                emoji: "ðŸ§¿",
                title: "Nazar Amulet",
            },
            {
                emoji: "ðŸ•¹ï¸",
                title: "Joystick",
            },
            {
                emoji: "ðŸ§¸",
                title: "Teddy Bear",
            },
            {
                emoji: "ðŸª…",
                title: "PiÃ±ata",
            },
            {
                emoji: "ðŸª†",
                title: "Nesting Dolls",
            },
            {
                emoji: "ðŸ–¼ï¸",
                title: "Framed Picture",
            },
            {
                emoji: "ðŸ§µ",
                title: "Thread",
            },
            {
                emoji: "ðŸª¡",
                title: "Sewing Needle",
            },
            {
                emoji: "ðŸ§¶",
                title: "Yarn",
            },
            {
                emoji: "ðŸª¢",
                title: "Knot",
            },
            {
                emoji: "ðŸ›ï¸",
                title: "Shopping Bags",
            },
            {
                emoji: "ðŸ“¿",
                title: "Prayer Beads",
            },
            {
                emoji: "ðŸ’Ž",
                title: "Gem Stone",
            },
            {
                emoji: "ðŸ“¯",
                title: "Postal Horn",
            },
            {
                emoji: "ðŸŽ™ï¸",
                title: "Studio Microphone",
            },
            {
                emoji: "ðŸŽšï¸",
                title: "Level Slider",
            },
            {
                emoji: "ðŸŽ›ï¸",
                title: "Control Knobs",
            },
            {
                emoji: "ðŸ“»",
                title: "Radio",
            },
            {
                emoji: "ðŸª•",
                title: "Banjo",
            },
            {
                emoji: "ðŸ“±",
                title: "Mobile Phone",
            },
            {
                emoji: "ðŸ“²",
                title: "Mobile Phone with Arrow",
            },
            {
                emoji: "â˜Žï¸",
                title: "Telephone",
            },
            {
                emoji: "ðŸ“ž",
                title: "Telephone Receiver",
            },
            {
                emoji: "ðŸ“Ÿ",
                title: "Pager",
            },
            {
                emoji: "ðŸ“ ",
                title: "Fax Machine",
            },
            {
                emoji: "ðŸ”‹",
                title: "Battery",
            },
            {
                emoji: "ðŸ”Œ",
                title: "Electric Plug",
            },
            {
                emoji: "ðŸ’»",
                title: "Laptop",
            },
            {
                emoji: "ðŸ–¥ï¸",
                title: "Desktop Computer",
            },
            {
                emoji: "ðŸ–¨ï¸",
                title: "Printer",
            },
            {
                emoji: "âŒ¨ï¸",
                title: "Keyboard",
            },
            {
                emoji: "ðŸ–±ï¸",
                title: "Computer Mouse",
            },
            {
                emoji: "ðŸ–²ï¸",
                title: "Trackball",
            },
            {
                emoji: "ðŸ’½",
                title: "Computer Disk",
            },
            {
                emoji: "ðŸ’¾",
                title: "Floppy Disk",
            },
            {
                emoji: "ðŸ’¿",
                title: "Optical Disk",
            },
            {
                emoji: "ðŸ“€",
                title: "DVD",
            },
            {
                emoji: "ðŸ§®",
                title: "Abacus",
            },
            {
                emoji: "ðŸŽ¥",
                title: "Movie Camera",
            },
            {
                emoji: "ðŸŽžï¸",
                title: "Film Frames",
            },
            {
                emoji: "ðŸ“½ï¸",
                title: "Film Projector",
            },
            {
                emoji: "ðŸ“º",
                title: "Television",
            },
            {
                emoji: "ðŸ“·",
                title: "Camera",
            },
            {
                emoji: "ðŸ“¸",
                title: "Camera with Flash",
            },
            {
                emoji: "ðŸ“¹",
                title: "Video Camera",
            },
            {
                emoji: "ðŸ“¼",
                title: "Videocassette",
            },
            {
                emoji: "ðŸ”",
                title: "Magnifying Glass Tilted Left",
            },
            {
                emoji: "ðŸ”Ž",
                title: "Magnifying Glass Tilted Right",
            },
            {
                emoji: "ðŸ•¯ï¸",
                title: "Candle",
            },
            {
                emoji: "ðŸ’¡",
                title: "Light Bulb",
            },
            {
                emoji: "ðŸ”¦",
                title: "Flashlight",
            },
            {
                emoji: "ðŸ®",
                title: "Red Paper Lantern",
            },
            {
                emoji: "ðŸª”",
                title: "Diya Lamp",
            },
            {
                emoji: "ðŸ“”",
                title: "Notebook with Decorative Cover",
            },
            {
                emoji: "ðŸ“•",
                title: "Closed Book",
            },
            {
                emoji: "ðŸ“–",
                title: "Open Book",
            },
            {
                emoji: "ðŸ“—",
                title: "Green Book",
            },
            {
                emoji: "ðŸ“˜",
                title: "Blue Book",
            },
            {
                emoji: "ðŸ“™",
                title: "Orange Book",
            },
            {
                emoji: "ðŸ“š",
                title: "Books",
            },
            {
                emoji: "ðŸ““",
                title: "Notebook",
            },
            {
                emoji: "ðŸ“’",
                title: "Ledger",
            },
            {
                emoji: "ðŸ“ƒ",
                title: "Page with Curl",
            },
            {
                emoji: "ðŸ“œ",
                title: "Scroll",
            },
            {
                emoji: "ðŸ“„",
                title: "Page Facing Up",
            },
            {
                emoji: "ðŸ“°",
                title: "Newspaper",
            },
            {
                emoji: "ðŸ—žï¸",
                title: "Rolled-Up Newspaper",
            },
            {
                emoji: "ðŸ“‘",
                title: "Bookmark Tabs",
            },
            {
                emoji: "ðŸ”–",
                title: "Bookmark",
            },
            {
                emoji: "ðŸ·ï¸",
                title: "Label",
            },
            {
                emoji: "ðŸ’°",
                title: "Money Bag",
            },
            {
                emoji: "ðŸª™",
                title: "Coin",
            },
            {
                emoji: "ðŸ’´",
                title: "Yen Banknote",
            },
            {
                emoji: "ðŸ’µ",
                title: "Dollar Banknote",
            },
            {
                emoji: "ðŸ’¶",
                title: "Euro Banknote",
            },
            {
                emoji: "ðŸ’·",
                title: "Pound Banknote",
            },
            {
                emoji: "ðŸ’¸",
                title: "Money with Wings",
            },
            {
                emoji: "ðŸ’³",
                title: "Credit Card",
            },
            {
                emoji: "ðŸ§¾",
                title: "Receipt",
            },
            {
                emoji: "âœ‰ï¸",
                title: "Envelope",
            },
            {
                emoji: "ðŸ“§",
                title: "E-Mail",
            },
            {
                emoji: "ðŸ“¨",
                title: "Incoming Envelope",
            },
            {
                emoji: "ðŸ“©",
                title: "Envelope with Arrow",
            },
            {
                emoji: "ðŸ“¤",
                title: "Outbox Tray",
            },
            {
                emoji: "ðŸ“¥",
                title: "Inbox Tray",
            },
            {
                emoji: "ðŸ“¦",
                title: "Package",
            },
            {
                emoji: "ðŸ“«",
                title: "Closed Mailbox with Raised Flag",
            },
            {
                emoji: "ðŸ“ª",
                title: "Closed Mailbox with Lowered Flag",
            },
            {
                emoji: "ðŸ“¬",
                title: "Open Mailbox with Raised Flag",
            },
            {
                emoji: "ðŸ“­",
                title: "Open Mailbox with Lowered Flag",
            },
            {
                emoji: "ðŸ“®",
                title: "Postbox",
            },
            {
                emoji: "ðŸ—³ï¸",
                title: "Ballot Box with Ballot",
            },
            {
                emoji: "âœï¸",
                title: "Pencil",
            },
            {
                emoji: "âœ’ï¸",
                title: "Black Nib",
            },
            {
                emoji: "ðŸ–‹ï¸",
                title: "Fountain Pen",
            },
            {
                emoji: "ðŸ–Šï¸",
                title: "Pen",
            },
            {
                emoji: "ðŸ–Œï¸",
                title: "Paintbrush",
            },
            {
                emoji: "ðŸ–ï¸",
                title: "Crayon",
            },
            {
                emoji: "ðŸ“",
                title: "Memo",
            },
            {
                emoji: "ðŸ“",
                title: "File Folder",
            },
            {
                emoji: "ðŸ“‚",
                title: "Open File Folder",
            },
            {
                emoji: "ðŸ—‚ï¸",
                title: "Card Index Dividers",
            },
            {
                emoji: "ðŸ“…",
                title: "Calendar",
            },
            {
                emoji: "ðŸ“†",
                title: "Tear-Off Calendar",
            },
            {
                emoji: "ðŸ—’ï¸",
                title: "Spiral Notepad",
            },
            {
                emoji: "ðŸ—“ï¸",
                title: "Spiral Calendar",
            },
            {
                emoji: "ðŸ“‡",
                title: "Card Index",
            },
            {
                emoji: "ðŸ“ˆ",
                title: "Chart Increasing",
            },
            {
                emoji: "ðŸ“‰",
                title: "Chart Decreasing",
            },
            {
                emoji: "ðŸ“Š",
                title: "Bar Chart",
            },
            {
                emoji: "ðŸ“‹",
                title: "Clipboard",
            },
            {
                emoji: "ðŸ“Œ",
                title: "Pushpin",
            },
            {
                emoji: "ðŸ“",
                title: "Round Pushpin",
            },
            {
                emoji: "ðŸ“Ž",
                title: "Paperclip",
            },
            {
                emoji: "ðŸ–‡ï¸",
                title: "Linked Paperclips",
            },
            {
                emoji: "ðŸ“",
                title: "Straight Ruler",
            },
            {
                emoji: "ðŸ“",
                title: "Triangular Ruler",
            },
            {
                emoji: "âœ‚ï¸",
                title: "Scissors",
            },
            {
                emoji: "ðŸ—ƒï¸",
                title: "Card File Box",
            },
            {
                emoji: "ðŸ—„ï¸",
                title: "File Cabinet",
            },
            {
                emoji: "ðŸ—‘ï¸",
                title: "Wastebasket",
            },
            {
                emoji: "ðŸ”’",
                title: "Locked",
            },
            {
                emoji: "ðŸ”“",
                title: "Unlocked",
            },
            {
                emoji: "ðŸ”",
                title: "Locked with Pen",
            },
            {
                emoji: "ðŸ”",
                title: "Locked with Key",
            },
            {
                emoji: "ðŸ”‘",
                title: "Key",
            },
            {
                emoji: "ðŸ—ï¸",
                title: "Old Key",
            },
            {
                emoji: "ðŸ”¨",
                title: "Hammer",
            },
            {
                emoji: "ðŸª“",
                title: "Axe",
            },
            {
                emoji: "â›ï¸",
                title: "Pick",
            },
            {
                emoji: "âš’ï¸",
                title: "Hammer and Pick",
            },
            {
                emoji: "ðŸ› ï¸",
                title: "Hammer and Wrench",
            },
            {
                emoji: "ðŸ—¡ï¸",
                title: "Dagger",
            },
            {
                emoji: "âš”ï¸",
                title: "Crossed Swords",
            },
            {
                emoji: "ðŸ”«",
                title: "Water Pistol",
            },
            {
                emoji: "ðŸªƒ",
                title: "Boomerang",
            },
            {
                emoji: "ðŸ›¡ï¸",
                title: "Shield",
            },
            {
                emoji: "ðŸªš",
                title: "Carpentry Saw",
            },
            {
                emoji: "ðŸ”§",
                title: "Wrench",
            },
            {
                emoji: "ðŸª›",
                title: "Screwdriver",
            },
            {
                emoji: "ðŸ”©",
                title: "Nut and Bolt",
            },
            {
                emoji: "âš™ï¸",
                title: "Gear",
            },
            {
                emoji: "ðŸ—œï¸",
                title: "Clamp",
            },
            {
                emoji: "âš–ï¸",
                title: "Balance Scale",
            },
            {
                emoji: "ðŸ¦¯",
                title: "White Cane",
            },
            {
                emoji: "ðŸ”—",
                title: "Link",
            },
            {
                emoji: "â›“ï¸",
                title: "Chains",
            },
            {
                emoji: "ðŸª",
                title: "Hook",
            },
            {
                emoji: "ðŸ§°",
                title: "Toolbox",
            },
            {
                emoji: "ðŸ§²",
                title: "Magnet",
            },
            {
                emoji: "ðŸªœ",
                title: "Ladder",
            },
            {
                emoji: "âš—ï¸",
                title: "Alembic",
            },
            {
                emoji: "ðŸ§ª",
                title: "Test Tube",
            },
            {
                emoji: "ðŸ§«",
                title: "Petri Dish",
            },
            {
                emoji: "ðŸ§¬",
                title: "DNA",
            },
            {
                emoji: "ðŸ”¬",
                title: "Microscope",
            },
            {
                emoji: "ðŸ”­",
                title: "Telescope",
            },
            {
                emoji: "ðŸ“¡",
                title: "Satellite Antenna",
            },
            {
                emoji: "ðŸ’‰",
                title: "Syringe",
            },
            {
                emoji: "ðŸ©¸",
                title: "Drop of Blood",
            },
            {
                emoji: "ðŸ’Š",
                title: "Pill",
            },
            {
                emoji: "ðŸ©¹",
                title: "Adhesive Bandage",
            },
            {
                emoji: "ðŸ©º",
                title: "Stethoscope",
            },
            {
                emoji: "ðŸšª",
                title: "Door",
            },
            {
                emoji: "ðŸªž",
                title: "Mirror",
            },
            {
                emoji: "ðŸªŸ",
                title: "Window",
            },
            {
                emoji: "ðŸ›ï¸",
                title: "Bed",
            },
            {
                emoji: "ðŸ›‹ï¸",
                title: "Couch and Lamp",
            },
            {
                emoji: "ðŸª‘",
                title: "Chair",
            },
            {
                emoji: "ðŸš½",
                title: "Toilet",
            },
            {
                emoji: "ðŸª ",
                title: "Plunger",
            },
            {
                emoji: "ðŸš¿",
                title: "Shower",
            },
            {
                emoji: "ðŸ›",
                title: "Bathtub",
            },
            {
                emoji: "ðŸª¤",
                title: "Mouse Trap",
            },
            {
                emoji: "ðŸª’",
                title: "Razor",
            },
            {
                emoji: "ðŸ§´",
                title: "Lotion Bottle",
            },
            {
                emoji: "ðŸ§·",
                title: "Safety Pin",
            },
            {
                emoji: "ðŸ§¹",
                title: "Broom",
            },
            {
                emoji: "ðŸ§º",
                title: "Basket",
            },
            {
                emoji: "ðŸ§»",
                title: "Roll of Paper",
            },
            {
                emoji: "ðŸª£",
                title: "Bucket",
            },
            {
                emoji: "ðŸ§¼",
                title: "Soap",
            },
            {
                emoji: "ðŸª¥",
                title: "Toothbrush",
            },
            {
                emoji: "ðŸ§½",
                title: "Sponge",
            },
            {
                emoji: "ðŸ§¯",
                title: "Fire Extinguisher",
            },
            {
                emoji: "ðŸ›’",
                title: "Shopping Cart",
            },
            {
                emoji: "ðŸš¬",
                title: "Cigarette",
            },
            {
                emoji: "âš°ï¸",
                title: "Coffin",
            },
            {
                emoji: "ðŸª¦",
                title: "Headstone",
            },
            {
                emoji: "âš±ï¸",
                title: "Funeral Urn",
            },
            {
                emoji: "ðŸ—¿",
                title: "Moai",
            },
            {
                emoji: "ðŸª§",
                title: "Placard",
            },
            {
                emoji: "ðŸš°",
                title: "Potable Water",
            },
        ],
        Symbols: [
            {
                emoji: "ðŸ’˜",
                title: "Heart with Arrow",
            },
            {
                emoji: "ðŸ’",
                title: "Heart with Ribbon",
            },
            {
                emoji: "ðŸ’–",
                title: "Sparkling Heart",
            },
            {
                emoji: "ðŸ’—",
                title: "Growing Heart",
            },
            {
                emoji: "ðŸ’“",
                title: "Beating Heart",
            },
            {
                emoji: "ðŸ’ž",
                title: "Revolving Hearts",
            },
            {
                emoji: "ðŸ’•",
                title: "Two Hearts",
            },
            {
                emoji: "ðŸ’Ÿ",
                title: "Heart Decoration",
            },
            {
                emoji: "â£ï¸",
                title: "Heart Exclamation",
            },
            {
                emoji: "ðŸ’”",
                title: "Broken Heart",
            },
            {
                emoji: "â¤ï¸â€ðŸ”¥",
                title: "Heart on Fire",
            },
            {
                emoji: "â¤ï¸â€ðŸ©¹",
                title: "Mending Heart",
            },
            {
                emoji: "â¤ï¸",
                title: "Red Heart",
            },
            {
                emoji: "ðŸ§¡",
                title: "Orange Heart",
            },
            {
                emoji: "ðŸ’›",
                title: "Yellow Heart",
            },
            {
                emoji: "ðŸ’š",
                title: "Green Heart",
            },
            {
                emoji: "ðŸ’™",
                title: "Blue Heart",
            },
            {
                emoji: "ðŸ’œ",
                title: "Purple Heart",
            },
            {
                emoji: "ðŸ¤Ž",
                title: "Brown Heart",
            },
            {
                emoji: "ðŸ–¤",
                title: "Black Heart",
            },
            {
                emoji: "ðŸ¤",
                title: "White Heart",
            },
            {
                emoji: "ðŸ’¯",
                title: "Hundred Points",
            },
            {
                emoji: "ðŸ’¢",
                title: "Anger Symbol",
            },
            {
                emoji: "ðŸ’¬",
                title: "Speech Balloon",
            },
            {
                emoji: "ðŸ‘ï¸â€ðŸ—¨ï¸",
                title: "Eye in Speech Bubble",
            },
            {
                emoji: "ðŸ—¨ï¸",
                title: "Left Speech Bubble",
            },
            {
                emoji: "ðŸ—¯ï¸",
                title: "Right Anger Bubble",
            },
            {
                emoji: "ðŸ’­",
                title: "Thought Balloon",
            },
            {
                emoji: "ðŸ’¤",
                title: "Zzz",
            },
            {
                emoji: "ðŸ’®",
                title: "White Flower",
            },
            {
                emoji: "â™¨ï¸",
                title: "Hot Springs",
            },
            {
                emoji: "ðŸ’ˆ",
                title: "Barber Pole",
            },
            {
                emoji: "ðŸ›‘",
                title: "Stop Sign",
            },
            {
                emoji: "ðŸ•›",
                title: "Twelve Oâ€™Clock",
            },
            {
                emoji: "ðŸ•§",
                title: "Twelve-Thirty",
            },
            {
                emoji: "ðŸ•",
                title: "One Oâ€™Clock",
            },
            {
                emoji: "ðŸ•œ",
                title: "One-Thirty",
            },
            {
                emoji: "ðŸ•‘",
                title: "Two Oâ€™Clock",
            },
            {
                emoji: "ðŸ•",
                title: "Two-Thirty",
            },
            {
                emoji: "ðŸ•’",
                title: "Three Oâ€™Clock",
            },
            {
                emoji: "ðŸ•ž",
                title: "Three-Thirty",
            },
            {
                emoji: "ðŸ•“",
                title: "Four Oâ€™Clock",
            },
            {
                emoji: "ðŸ•Ÿ",
                title: "Four-Thirty",
            },
            {
                emoji: "ðŸ•”",
                title: "Five Oâ€™Clock",
            },
            {
                emoji: "ðŸ• ",
                title: "Five-Thirty",
            },
            {
                emoji: "ðŸ••",
                title: "Six Oâ€™Clock",
            },
            {
                emoji: "ðŸ•¡",
                title: "Six-Thirty",
            },
            {
                emoji: "ðŸ•–",
                title: "Seven Oâ€™Clock",
            },
            {
                emoji: "ðŸ•¢",
                title: "Seven-Thirty",
            },
            {
                emoji: "ðŸ•—",
                title: "Eight Oâ€™Clock",
            },
            {
                emoji: "ðŸ•£",
                title: "Eight-Thirty",
            },
            {
                emoji: "ðŸ•˜",
                title: "Nine Oâ€™Clock",
            },
            {
                emoji: "ðŸ•¤",
                title: "Nine-Thirty",
            },
            {
                emoji: "ðŸ•™",
                title: "Ten Oâ€™Clock",
            },
            {
                emoji: "ðŸ•¥",
                title: "Ten-Thirty",
            },
            {
                emoji: "ðŸ•š",
                title: "Eleven Oâ€™Clock",
            },
            {
                emoji: "ðŸ•¦",
                title: "Eleven-Thirty",
            },
            {
                emoji: "ðŸŒ€",
                title: "Cyclone",
            },
            {
                emoji: "â™ ï¸",
                title: "Spade Suit",
            },
            {
                emoji: "â™¥ï¸",
                title: "Heart Suit",
            },
            {
                emoji: "â™¦ï¸",
                title: "Diamond Suit",
            },
            {
                emoji: "â™£ï¸",
                title: "Club Suit",
            },
            {
                emoji: "ðŸƒ",
                title: "Joker",
            },
            {
                emoji: "ðŸ€„",
                title: "Mahjong Red Dragon",
            },
            {
                emoji: "ðŸŽ´",
                title: "Flower Playing Cards",
            },
            {
                emoji: "ðŸ”‡",
                title: "Muted Speaker",
            },
            {
                emoji: "ðŸ”ˆ",
                title: "Speaker Low Volume",
            },
            {
                emoji: "ðŸ”‰",
                title: "Speaker Medium Volume",
            },
            {
                emoji: "ðŸ”Š",
                title: "Speaker High Volume",
            },
            {
                emoji: "ðŸ“¢",
                title: "Loudspeaker",
            },
            {
                emoji: "ðŸ“£",
                title: "Megaphone",
            },
            {
                emoji: "ðŸ“¯",
                title: "Postal Horn",
            },
            {
                emoji: "ðŸ””",
                title: "Bell",
            },
            {
                emoji: "ðŸ”•",
                title: "Bell with Slash",
            },
            {
                emoji: "ðŸŽµ",
                title: "Musical Note",
            },
            {
                emoji: "ðŸŽ¶",
                title: "Musical Notes",
            },
            {
                emoji: "ðŸ’¹",
                title: "Chart Increasing with Yen",
            },
            {
                emoji: "ðŸ›—",
                title: "Elevator",
            },
            {
                emoji: "ðŸ§",
                title: "ATM Sign",
            },
            {
                emoji: "ðŸš®",
                title: "Litter in Bin Sign",
            },
            {
                emoji: "ðŸš°",
                title: "Potable Water",
            },
            {
                emoji: "â™¿",
                title: "Wheelchair Symbol",
            },
            {
                emoji: "ðŸš¹",
                title: "Menâ€™s Room",
            },
            {
                emoji: "ðŸšº",
                title: "Womenâ€™s Room",
            },
            {
                emoji: "ðŸš»",
                title: "Restroom",
            },
            {
                emoji: "ðŸš¼",
                title: "Baby Symbol",
            },
            {
                emoji: "ðŸš¾",
                title: "Water Closet",
            },
            {
                emoji: "âš ï¸",
                title: "Warning",
            },
            {
                emoji: "ðŸš¸",
                title: "Children Crossing",
            },
            {
                emoji: "â›”",
                title: "No Entry",
            },
            {
                emoji: "ðŸš«",
                title: "Prohibited",
            },
            {
                emoji: "ðŸš³",
                title: "No Bicycles",
            },
            {
                emoji: "ðŸš­",
                title: "No Smoking",
            },
            {
                emoji: "ðŸš¯",
                title: "No Littering",
            },
            {
                emoji: "ðŸš±",
                title: "Non-Potable Water",
            },
            {
                emoji: "ðŸš·",
                title: "No Pedestrians",
            },
            {
                emoji: "ðŸ“µ",
                title: "No Mobile Phones",
            },
            {
                emoji: "ðŸ”ž",
                title: "No One Under Eighteen",
            },
            {
                emoji: "â˜¢ï¸",
                title: "Radioactive",
            },
            {
                emoji: "â˜£ï¸",
                title: "Biohazard",
            },
            {
                emoji: "â¬†ï¸",
                title: "Up Arrow",
            },
            {
                emoji: "â†—ï¸",
                title: "Up-Right Arrow",
            },
            {
                emoji: "âž¡ï¸",
                title: "Right Arrow",
            },
            {
                emoji: "â†˜ï¸",
                title: "Down-Right Arrow",
            },
            {
                emoji: "â¬‡ï¸",
                title: "Down Arrow",
            },
            {
                emoji: "â†™ï¸",
                title: "Down-Left Arrow",
            },
            {
                emoji: "â¬…ï¸",
                title: "Left Arrow",
            },
            {
                emoji: "â†–ï¸",
                title: "Up-Left Arrow",
            },
            {
                emoji: "â†•ï¸",
                title: "Up-Down Arrow",
            },
            {
                emoji: "â†”ï¸",
                title: "Left-Right Arrow",
            },
            {
                emoji: "â†©ï¸",
                title: "Right Arrow Curving Left",
            },
            {
                emoji: "â†ªï¸",
                title: "Left Arrow Curving Right",
            },
            {
                emoji: "â¤´ï¸",
                title: "Right Arrow Curving Up",
            },
            {
                emoji: "â¤µï¸",
                title: "Right Arrow Curving Down",
            },
            {
                emoji: "ðŸ”ƒ",
                title: "Clockwise Vertical Arrows",
            },
            {
                emoji: "ðŸ”„",
                title: "Counterclockwise Arrows Button",
            },
            {
                emoji: "ðŸ”™",
                title: "Back Arrow",
            },
            {
                emoji: "ðŸ”š",
                title: "End Arrow",
            },
            {
                emoji: "ðŸ”›",
                title: "On! Arrow",
            },
            {
                emoji: "ðŸ”œ",
                title: "Soon Arrow",
            },
            {
                emoji: "ðŸ”",
                title: "Top Arrow",
            },
            {
                emoji: "ðŸ›",
                title: "Place of Worship",
            },
            {
                emoji: "âš›ï¸",
                title: "Atom Symbol",
            },
            {
                emoji: "ðŸ•‰ï¸",
                title: "Om",
            },
            {
                emoji: "âœ¡ï¸",
                title: "Star of David",
            },
            {
                emoji: "â˜¸ï¸",
                title: "Wheel of Dharma",
            },
            {
                emoji: "â˜¯ï¸",
                title: "Yin Yang",
            },
            {
                emoji: "âœï¸",
                title: "Latin Cross",
            },
            {
                emoji: "â˜¦ï¸",
                title: "Orthodox Cross",
            },
            {
                emoji: "â˜ªï¸",
                title: "Star and Crescent",
            },
            {
                emoji: "â˜®ï¸",
                title: "Peace Symbol",
            },
            {
                emoji: "ðŸ•Ž",
                title: "Menorah",
            },
            {
                emoji: "ðŸ”¯",
                title: "Dotted Six-Pointed Star",
            },
            {
                emoji: "â™ˆ",
                title: "Aries",
            },
            {
                emoji: "â™‰",
                title: "Taurus",
            },
            {
                emoji: "â™Š",
                title: "Gemini",
            },
            {
                emoji: "â™‹",
                title: "Cancer",
            },
            {
                emoji: "â™Œ",
                title: "Leo",
            },
            {
                emoji: "â™",
                title: "Virgo",
            },
            {
                emoji: "â™Ž",
                title: "Libra",
            },
            {
                emoji: "â™",
                title: "Scorpio",
            },
            {
                emoji: "â™",
                title: "Sagittarius",
            },
            {
                emoji: "â™‘",
                title: "Capricorn",
            },
            {
                emoji: "â™’",
                title: "Aquarius",
            },
            {
                emoji: "â™“",
                title: "Pisces",
            },
            {
                emoji: "â›Ž",
                title: "Ophiuchus",
            },
            {
                emoji: "ðŸ”€",
                title: "Shuffle Tracks Button",
            },
            {
                emoji: "ðŸ”",
                title: "Repeat Button",
            },
            {
                emoji: "ðŸ”‚",
                title: "Repeat Single Button",
            },
            {
                emoji: "â–¶ï¸",
                title: "Play Button",
            },
            {
                emoji: "â©",
                title: "Fast-Forward Button",
            },
            {
                emoji: "â­ï¸",
                title: "Next Track Button",
            },
            {
                emoji: "â¯ï¸",
                title: "Play or Pause Button",
            },
            {
                emoji: "â—€ï¸",
                title: "Reverse Button",
            },
            {
                emoji: "âª",
                title: "Fast Reverse Button",
            },
            {
                emoji: "â®ï¸",
                title: "Last Track Button",
            },
            {
                emoji: "ðŸ”¼",
                title: "Upwards Button",
            },
            {
                emoji: "â«",
                title: "Fast Up Button",
            },
            {
                emoji: "ðŸ”½",
                title: "Downwards Button",
            },
            {
                emoji: "â¬",
                title: "Fast Down Button",
            },
            {
                emoji: "â¸ï¸",
                title: "Pause Button",
            },
            {
                emoji: "â¹ï¸",
                title: "Stop Button",
            },
            {
                emoji: "âºï¸",
                title: "Record Button",
            },
            {
                emoji: "âï¸",
                title: "Eject Button",
            },
            {
                emoji: "ðŸŽ¦",
                title: "Cinema",
            },
            {
                emoji: "ðŸ”…",
                title: "Dim Button",
            },
            {
                emoji: "ðŸ”†",
                title: "Bright Button",
            },
            {
                emoji: "ðŸ“¶",
                title: "Antenna Bars",
            },
            {
                emoji: "ðŸ“³",
                title: "Vibration Mode",
            },
            {
                emoji: "ðŸ“´",
                title: "Mobile Phone Off",
            },
            {
                emoji: "â™€ï¸",
                title: "Female Sign",
            },
            {
                emoji: "â™‚ï¸",
                title: "Male Sign",
            },
            {
                emoji: "âœ–ï¸",
                title: "Multiply",
            },
            {
                emoji: "âž•",
                title: "Plus",
            },
            {
                emoji: "âž–",
                title: "Minus",
            },
            {
                emoji: "âž—",
                title: "Divide",
            },
            {
                emoji: "â™¾ï¸",
                title: "Infinity",
            },
            {
                emoji: "â€¼ï¸",
                title: "â€¼ Double Exclamation Mark",
            },
            {
                emoji: "â‰ï¸",
                title: "â‰ Exclamation Question Mark",
            },
            {
                emoji: "â“",
                title: "Red Question Mark",
            },
            {
                emoji: "â”",
                title: "White Question Mark",
            },
            {
                emoji: "â•",
                title: "White Exclamation Mark",
            },
            {
                emoji: "â—",
                title: "Red Exclamation Mark",
            },
            {
                emoji: "ã€°ï¸",
                title: "ã€° Wavy Dash",
            },
            {
                emoji: "ðŸ’±",
                title: "Currency Exchange",
            },
            {
                emoji: "ðŸ’²",
                title: "Heavy Dollar Sign",
            },
            {
                emoji: "âš•ï¸",
                title: "Medical Symbol",
            },
            {
                emoji: "â™»ï¸",
                title: "Recycling Symbol",
            },
            {
                emoji: "âšœï¸",
                title: "Fleur-de-lis",
            },
            {
                emoji: "ðŸ”±",
                title: "Trident Emblem",
            },
            {
                emoji: "ðŸ“›",
                title: "Name Badge",
            },
            {
                emoji: "ðŸ”°",
                title: "Japanese Symbol for Beginner",
            },
            {
                emoji: "â­•",
                title: "Hollow Red Circle",
            },
            {
                emoji: "âœ…",
                title: "Check Mark Button",
            },
            {
                emoji: "â˜‘ï¸",
                title: "Check Box with Check",
            },
            {
                emoji: "âœ”ï¸",
                title: "Check Mark",
            },
            {
                emoji: "âŒ",
                title: "Cross Mark",
            },
            {
                emoji: "âŽ",
                title: "Cross Mark Button",
            },
            {
                emoji: "âž°",
                title: "Curly Loop",
            },
            {
                emoji: "âž¿",
                title: "Double Curly Loop",
            },
            {
                emoji: "ã€½ï¸",
                title: "ã€½ Part Alternation Mark",
            },
            {
                emoji: "âœ³ï¸",
                title: "Eight-Spoked Asterisk",
            },
            {
                emoji: "âœ´ï¸",
                title: "Eight-Pointed Star",
            },
            {
                emoji: "â‡ï¸",
                title: "Sparkle",
            },
            {
                emoji: "Â©ï¸",
                title: "Copyright",
            },
            {
                emoji: "Â®ï¸",
                title: "Registered",
            },
            {
                emoji: "â„¢ï¸",
                title: "Trade Mark",
            },
            {
                emoji: "#ï¸âƒ£",
                title: "# Keycap Number Sign",
            },
            {
                emoji: "*ï¸âƒ£",
                title: "* Keycap Asterisk",
            },
            {
                emoji: "0ï¸âƒ£",
                title: "0 Keycap Digit Zero",
            },
            {
                emoji: "1ï¸âƒ£",
                title: "1 Keycap Digit One",
            },
            {
                emoji: "2ï¸âƒ£",
                title: "2 Keycap Digit Two",
            },
            {
                emoji: "3ï¸âƒ£",
                title: "3 Keycap Digit Three",
            },
            {
                emoji: "4ï¸âƒ£",
                title: "4 Keycap Digit Four",
            },
            {
                emoji: "5ï¸âƒ£",
                title: "5 Keycap Digit Five",
            },
            {
                emoji: "6ï¸âƒ£",
                title: "6 Keycap Digit Six",
            },
            {
                emoji: "7ï¸âƒ£",
                title: "7 Keycap Digit Seven",
            },
            {
                emoji: "8ï¸âƒ£",
                title: "8 Keycap Digit Eight",
            },
            {
                emoji: "9ï¸âƒ£",
                title: "9 Keycap Digit Nine",
            },
            {
                emoji: "ðŸ”Ÿ",
                title: "Keycap: 10",
            },
            {
                emoji: "ðŸ” ",
                title: "Input Latin Uppercase",
            },
            {
                emoji: "ðŸ”¡",
                title: "Input Latin Lowercase",
            },
            {
                emoji: "ðŸ”¢",
                title: "Input Numbers",
            },
            {
                emoji: "ðŸ”£",
                title: "Input Symbols",
            },
            {
                emoji: "ðŸ”¤",
                title: "Input Latin Letters",
            },
            {
                emoji: "ðŸ…°ï¸",
                title: "A Button (Blood Type)",
            },
            {
                emoji: "ðŸ†Ž",
                title: "AB Button (Blood Type)",
            },
            {
                emoji: "ðŸ…±ï¸",
                title: "B Button (Blood Type)",
            },
            {
                emoji: "ðŸ†‘",
                title: "CL Button",
            },
            {
                emoji: "ðŸ†’",
                title: "Cool Button",
            },
            {
                emoji: "ðŸ†“",
                title: "Free Button",
            },
            {
                emoji: "â„¹ï¸",
                title: "â„¹ Information",
            },
            {
                emoji: "ðŸ†”",
                title: "ID Button",
            },
            {
                emoji: "â“‚ï¸",
                title: "Circled M",
            },
            {
                emoji: "ðŸ†•",
                title: "New Button",
            },
            {
                emoji: "ðŸ†–",
                title: "NG Button",
            },
            {
                emoji: "ðŸ…¾ï¸",
                title: "O Button (Blood Type)",
            },
            {
                emoji: "ðŸ†—",
                title: "OK Button",
            },
            {
                emoji: "ðŸ…¿ï¸",
                title: "P Button",
            },
            {
                emoji: "ðŸ†˜",
                title: "SOS Button",
            },
            {
                emoji: "ðŸ†™",
                title: "Up! Button",
            },
            {
                emoji: "ðŸ†š",
                title: "Vs Button",
            },
            {
                emoji: "ðŸˆ",
                title: "Japanese â€œHereâ€ Button",
            },
            {
                emoji: "ðŸˆ‚ï¸",
                title: "Japanese â€œService Chargeâ€ Button",
            },
            {
                emoji: "ðŸˆ·ï¸",
                title: "Japanese â€œMonthly Amountâ€ Button",
            },
            {
                emoji: "ðŸˆ¶",
                title: "Japanese â€œNot Free of Chargeâ€ Button",
            },
            {
                emoji: "ðŸˆ¯",
                title: "Japanese â€œReservedâ€ Button",
            },
            {
                emoji: "ðŸ‰",
                title: "Japanese â€œBargainâ€ Button",
            },
            {
                emoji: "ðŸˆ¹",
                title: "Japanese â€œDiscountâ€ Button",
            },
            {
                emoji: "ðŸˆš",
                title: "Japanese â€œFree of Chargeâ€ Button",
            },
            {
                emoji: "ðŸˆ²",
                title: "Japanese â€œProhibitedâ€ Button",
            },
            {
                emoji: "ðŸ‰‘",
                title: "Japanese â€œAcceptableâ€ Button",
            },
            {
                emoji: "ðŸˆ¸",
                title: "Japanese â€œApplicationâ€ Button",
            },
            {
                emoji: "ðŸˆ´",
                title: "Japanese â€œPassing Gradeâ€ Button",
            },
            {
                emoji: "ðŸˆ³",
                title: "Japanese â€œVacancyâ€ Button",
            },
            {
                emoji: "ãŠ—ï¸",
                title: "Japanese â€œCongratulationsâ€ Button",
            },
            {
                emoji: "ãŠ™ï¸",
                title: "Japanese â€œSecretâ€ Button",
            },
            {
                emoji: "ðŸˆº",
                title: "Japanese â€œOpen for Businessâ€ Button",
            },
            {
                emoji: "ðŸˆµ",
                title: "Japanese â€œNo Vacancyâ€ Button",
            },
            {
                emoji: "ðŸ”´",
                title: "Red Circle",
            },
            {
                emoji: "ðŸŸ ",
                title: "Orange Circle",
            },
            {
                emoji: "ðŸŸ¡",
                title: "Yellow Circle",
            },
            {
                emoji: "ðŸŸ¢",
                title: "Green Circle",
            },
            {
                emoji: "ðŸ”µ",
                title: "Blue Circle",
            },
            {
                emoji: "ðŸŸ£",
                title: "Purple Circle",
            },
            {
                emoji: "ðŸŸ¤",
                title: "Brown Circle",
            },
            {
                emoji: "âš«",
                title: "Black Circle",
            },
            {
                emoji: "âšª",
                title: "White Circle",
            },
            {
                emoji: "ðŸŸ¥",
                title: "Red Square",
            },
            {
                emoji: "ðŸŸ§",
                title: "Orange Square",
            },
            {
                emoji: "ðŸŸ¨",
                title: "Yellow Square",
            },
            {
                emoji: "ðŸŸ©",
                title: "Green Square",
            },
            {
                emoji: "ðŸŸ¦",
                title: "Blue Square",
            },
            {
                emoji: "ðŸŸª",
                title: "Purple Square",
            },
            {
                emoji: "ðŸŸ«",
                title: "Brown Square",
            },
            {
                emoji: "â¬›",
                title: "Black Large Square",
            },
            {
                emoji: "â¬œ",
                title: "White Large Square",
            },
            {
                emoji: "â—¼ï¸",
                title: "Black Medium Square",
            },
            {
                emoji: "â—»ï¸",
                title: "White Medium Square",
            },
            {
                emoji: "â—¾",
                title: "Black Medium-Small Square",
            },
            {
                emoji: "â—½",
                title: "White Medium-Small Square",
            },
            {
                emoji: "â–ªï¸",
                title: "Black Small Square",
            },
            {
                emoji: "â–«ï¸",
                title: "White Small Square",
            },
            {
                emoji: "ðŸ”¶",
                title: "Large Orange Diamond",
            },
            {
                emoji: "ðŸ”·",
                title: "Large Blue Diamond",
            },
            {
                emoji: "ðŸ”¸",
                title: "Small Orange Diamond",
            },
            {
                emoji: "ðŸ”¹",
                title: "Small Blue Diamond",
            },
            {
                emoji: "ðŸ”º",
                title: "Red Triangle Pointed Up",
            },
            {
                emoji: "ðŸ”»",
                title: "Red Triangle Pointed Down",
            },
            {
                emoji: "ðŸ’ ",
                title: "Diamond with a Dot",
            },
            {
                emoji: "ðŸ”˜",
                title: "Radio Button",
            },
            {
                emoji: "ðŸ”³",
                title: "White Square Button",
            },
            {
                emoji: "ðŸ”²",
                title: "Black Square Button",
            },
        ],
        Flags: [
            {
                emoji: "ðŸ",
                title: "Chequered Flag",
            },
            {
                emoji: "ðŸš©",
                title: "Triangular Flag",
            },
            {
                emoji: "ðŸŽŒ",
                title: "Crossed Flags",
            },
            {
                emoji: "ðŸ´",
                title: "Black Flag",
            },
            {
                emoji: "ðŸ³ï¸",
                title: "White Flag",
            },
            {
                emoji: "ðŸ³ï¸â€ðŸŒˆ",
                title: "Rainbow Flag",
            },
            {
                emoji: "ðŸ³ï¸â€âš§ï¸",
                title: "Transgender Flag",
            },
            {
                emoji: "ðŸ´â€â˜ ï¸",
                title: "Pirate Flag",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡¨",
                title: "Flag: Ascension Island",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡©",
                title: "Flag: Andorra",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡ª",
                title: "Flag: United Arab Emirates",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡«",
                title: "Flag: Afghanistan",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡¬",
                title: "Flag: Antigua & Barbuda",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡®",
                title: "Flag: Anguilla",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡±",
                title: "Flag: Albania",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡²",
                title: "Flag: Armenia",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡´",
                title: "Flag: Angola",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡¶",
                title: "Flag: Antarctica",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡·",
                title: "Flag: Argentina",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡¸",
                title: "Flag: American Samoa",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡¹",
                title: "Flag: Austria",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡º",
                title: "Flag: Australia",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡¼",
                title: "Flag: Aruba",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡½",
                title: "Flag: Ã…land Islands",
            },
            {
                emoji: "ðŸ‡¦ðŸ‡¿",
                title: "Flag: Azerbaijan",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¦",
                title: "Flag: Bosnia & Herzegovina",
            },
            {
                emoji: "ðŸ‡§ðŸ‡§",
                title: "Flag: Barbados",
            },
            {
                emoji: "ðŸ‡§ðŸ‡©",
                title: "Flag: Bangladesh",
            },
            {
                emoji: "ðŸ‡§ðŸ‡ª",
                title: "Flag: Belgium",
            },
            {
                emoji: "ðŸ‡§ðŸ‡«",
                title: "Flag: Burkina Faso",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¬",
                title: "Flag: Bulgaria",
            },
            {
                emoji: "ðŸ‡§ðŸ‡­",
                title: "Flag: Bahrain",
            },
            {
                emoji: "ðŸ‡§ðŸ‡®",
                title: "Flag: Burundi",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¯",
                title: "Flag: Benin",
            },
            {
                emoji: "ðŸ‡§ðŸ‡±",
                title: "Flag: St. BarthÃ©lemy",
            },
            {
                emoji: "ðŸ‡§ðŸ‡²",
                title: "Flag: Bermuda",
            },
            {
                emoji: "ðŸ‡§ðŸ‡³",
                title: "Flag: Brunei",
            },
            {
                emoji: "ðŸ‡§ðŸ‡´",
                title: "Flag: Bolivia",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¶",
                title: "Flag: Caribbean Netherlands",
            },
            {
                emoji: "ðŸ‡§ðŸ‡·",
                title: "Flag: Brazil",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¸",
                title: "Flag: Bahamas",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¹",
                title: "Flag: Bhutan",
            },
            {
                emoji: "ðŸ‡§ðŸ‡»",
                title: "Flag: Bouvet Island",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¼",
                title: "Flag: Botswana",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¾",
                title: "Flag: Belarus",
            },
            {
                emoji: "ðŸ‡§ðŸ‡¿",
                title: "Flag: Belize",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡¦",
                title: "Flag: Canada",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡¨",
                title: "Flag: Cocos (Keeling) Islands",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡©",
                title: "Flag: Congo - Kinshasa",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡«",
                title: "Flag: Central African Republic",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡¬",
                title: "Flag: Congo - Brazzaville",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡­",
                title: "Flag: Switzerland",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡®",
                title: "Flag: CÃ´te dâ€™Ivoire",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡°",
                title: "Flag: Cook Islands",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡±",
                title: "Flag: Chile",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡²",
                title: "Flag: Cameroon",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡³",
                title: "Flag: China",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡´",
                title: "Flag: Colombia",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡µ",
                title: "Flag: Clipperton Island",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡·",
                title: "Flag: Costa Rica",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡º",
                title: "Flag: Zono",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡»",
                title: "Flag: Cape Verde",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡¼",
                title: "Flag: CuraÃ§ao",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡½",
                title: "Flag: Christmas Island",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡¾",
                title: "Flag: Cyprus",
            },
            {
                emoji: "ðŸ‡¨ðŸ‡¿",
                title: "Flag: Czechia",
            },
            {
                emoji: "ðŸ‡©ðŸ‡ª",
                title: "Flag: Germany",
            },
            {
                emoji: "ðŸ‡©ðŸ‡¬",
                title: "Flag: Diego Garcia",
            },
            {
                emoji: "ðŸ‡©ðŸ‡¯",
                title: "Flag: Djibouti",
            },
            {
                emoji: "ðŸ‡©ðŸ‡°",
                title: "Flag: Denmark",
            },
            {
                emoji: "ðŸ‡©ðŸ‡²",
                title: "Flag: Dominica",
            },
            {
                emoji: "ðŸ‡©ðŸ‡´",
                title: "Flag: Dominican Republic",
            },
            {
                emoji: "ðŸ‡©ðŸ‡¿",
                title: "Flag: Algeria",
            },
            {
                emoji: "ðŸ‡ªðŸ‡¦",
                title: "Flag: Ceuta & Melilla",
            },
            {
                emoji: "ðŸ‡ªðŸ‡¨",
                title: "Flag: Ecuador",
            },
            {
                emoji: "ðŸ‡ªðŸ‡ª",
                title: "Flag: Estonia",
            },
            {
                emoji: "ðŸ‡ªðŸ‡¬",
                title: "Flag: Egypt",
            },
            {
                emoji: "ðŸ‡ªðŸ‡­",
                title: "Flag: Western Sahara",
            },
            {
                emoji: "ðŸ‡ªðŸ‡·",
                title: "Flag: Eritrea",
            },
            {
                emoji: "ðŸ‡ªðŸ‡¸",
                title: "Flag: Spain",
            },
            {
                emoji: "ðŸ‡ªðŸ‡¹",
                title: "Flag: Ethiopia",
            },
            {
                emoji: "ðŸ‡ªðŸ‡º",
                title: "Flag: European Union",
            },
            {
                emoji: "ðŸ‡«ðŸ‡®",
                title: "Flag: Finland",
            },
            {
                emoji: "ðŸ‡«ðŸ‡¯",
                title: "Flag: Fiji",
            },
            {
                emoji: "ðŸ‡«ðŸ‡°",
                title: "Flag: Falkland Islands",
            },
            {
                emoji: "ðŸ‡«ðŸ‡²",
                title: "Flag: Micronesia",
            },
            {
                emoji: "ðŸ‡«ðŸ‡´",
                title: "Flag: Faroe Islands",
            },
            {
                emoji: "ðŸ‡«ðŸ‡·",
                title: "Flag: France",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡¦",
                title: "Flag: Gabon",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡§",
                title: "Flag: United Kingdom",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡©",
                title: "Flag: Grenada",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡ª",
                title: "Flag: Georgia",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡«",
                title: "Flag: French Guiana",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡¬",
                title: "Flag: Guernsey",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡­",
                title: "Flag: Ghana",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡®",
                title: "Flag: Gibraltar",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡±",
                title: "Flag: Greenland",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡²",
                title: "Flag: Gambia",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡³",
                title: "Flag: Guinea",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡µ",
                title: "Flag: Guadeloupe",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡¶",
                title: "Flag: Equatorial Guinea",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡·",
                title: "Flag: Greece",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡¸",
                title: "Flag: South Georgia & South Sandwich Islands",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡¹",
                title: "Flag: Guatemala",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡º",
                title: "Flag: Guam",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡¼",
                title: "Flag: Guinea-Bissau",
            },
            {
                emoji: "ðŸ‡¬ðŸ‡¾",
                title: "Flag: Guyana",
            },
            {
                emoji: "ðŸ‡­ðŸ‡°",
                title: "Flag: Hong Kong SAR China",
            },
            {
                emoji: "ðŸ‡­ðŸ‡²",
                title: "Flag: Heard & McDonald Islands",
            },
            {
                emoji: "ðŸ‡­ðŸ‡³",
                title: "Flag: Honduras",
            },
            {
                emoji: "ðŸ‡­ðŸ‡·",
                title: "Flag: Croatia",
            },
            {
                emoji: "ðŸ‡­ðŸ‡¹",
                title: "Flag: Haiti",
            },
            {
                emoji: "ðŸ‡­ðŸ‡º",
                title: "Flag: Hungary",
            },
            {
                emoji: "ðŸ‡®ðŸ‡¨",
                title: "Flag: Canary Islands",
            },
            {
                emoji: "ðŸ‡®ðŸ‡©",
                title: "Flag: Indonesia",
            },
            {
                emoji: "ðŸ‡®ðŸ‡ª",
                title: "Flag: Ireland",
            },
            {
                emoji: "ðŸ‡®ðŸ‡±",
                title: "Flag: Israel",
            },
            {
                emoji: "ðŸ‡®ðŸ‡²",
                title: "Flag: Isle of Man",
            },
            {
                emoji: "ðŸ‡®ðŸ‡³",
                title: "Flag: India",
            },
            {
                emoji: "ðŸ‡®ðŸ‡´",
                title: "Flag: British Indian Ocean Territory",
            },
            {
                emoji: "ðŸ‡®ðŸ‡¶",
                title: "Flag: Iraq",
            },
            {
                emoji: "ðŸ‡®ðŸ‡·",
                title: "Flag: Iran",
            },
            {
                emoji: "ðŸ‡®ðŸ‡¸",
                title: "Flag: Iceland",
            },
            {
                emoji: "ðŸ‡®ðŸ‡¹",
                title: "Flag: Italy",
            },
            {
                emoji: "ðŸ‡¯ðŸ‡ª",
                title: "Flag: Jersey",
            },
            {
                emoji: "ðŸ‡¯ðŸ‡²",
                title: "Flag: Jamaica",
            },
            {
                emoji: "ðŸ‡¯ðŸ‡´",
                title: "Flag: Jordan",
            },
            {
                emoji: "ðŸ‡¯ðŸ‡µ",
                title: "Flag: Japan",
            },
            {
                emoji: "ðŸ‡°ðŸ‡ª",
                title: "Flag: Kenya",
            },
            {
                emoji: "ðŸ‡°ðŸ‡¬",
                title: "Flag: Kyrgyzstan",
            },
            {
                emoji: "ðŸ‡°ðŸ‡­",
                title: "Flag: Cambodia",
            },
            {
                emoji: "ðŸ‡°ðŸ‡®",
                title: "Flag: Kiribati",
            },
            {
                emoji: "ðŸ‡°ðŸ‡²",
                title: "Flag: Comoros",
            },
            {
                emoji: "ðŸ‡°ðŸ‡³",
                title: "Flag: St. Kitts & Nevis",
            },
            {
                emoji: "ðŸ‡°ðŸ‡µ",
                title: "Flag: North Korea",
            },
            {
                emoji: "ðŸ‡°ðŸ‡·",
                title: "Flag: South Korea",
            },
            {
                emoji: "ðŸ‡°ðŸ‡¼",
                title: "Flag: Kuwait",
            },
            {
                emoji: "ðŸ‡°ðŸ‡¾",
                title: "Flag: Cayman Islands",
            },
            {
                emoji: "ðŸ‡°ðŸ‡¿",
                title: "Flag: Kazakhstan",
            },
            {
                emoji: "ðŸ‡±ðŸ‡¦",
                title: "Flag: Laos",
            },
            {
                emoji: "ðŸ‡±ðŸ‡§",
                title: "Flag: Lebanon",
            },
            {
                emoji: "ðŸ‡±ðŸ‡¨",
                title: "Flag: St. Lucia",
            },
            {
                emoji: "ðŸ‡±ðŸ‡®",
                title: "Flag: Liechtenstein",
            },
            {
                emoji: "ðŸ‡±ðŸ‡°",
                title: "Flag: Sri Lanka",
            },
            {
                emoji: "ðŸ‡±ðŸ‡·",
                title: "Flag: Liberia",
            },
            {
                emoji: "ðŸ‡±ðŸ‡¸",
                title: "Flag: Lesotho",
            },
            {
                emoji: "ðŸ‡±ðŸ‡¹",
                title: "Flag: Lithuania",
            },
            {
                emoji: "ðŸ‡±ðŸ‡º",
                title: "Flag: Luxembourg",
            },
            {
                emoji: "ðŸ‡±ðŸ‡»",
                title: "Flag: Latvia",
            },
            {
                emoji: "ðŸ‡±ðŸ‡¾",
                title: "Flag: Libya",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¦",
                title: "Flag: Morocco",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¨",
                title: "Flag: Monaco",
            },
            {
                emoji: "ðŸ‡²ðŸ‡©",
                title: "Flag: Moldova",
            },
            {
                emoji: "ðŸ‡²ðŸ‡ª",
                title: "Flag: Montenegro",
            },
            {
                emoji: "ðŸ‡²ðŸ‡«",
                title: "Flag: St. Martin",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¬",
                title: "Flag: Madagascar",
            },
            {
                emoji: "ðŸ‡²ðŸ‡­",
                title: "Flag: Marshall Islands",
            },
            {
                emoji: "ðŸ‡²ðŸ‡°",
                title: "Flag: North Macedonia",
            },
            {
                emoji: "ðŸ‡²ðŸ‡±",
                title: "Flag: Mali",
            },
            {
                emoji: "ðŸ‡²ðŸ‡²",
                title: "Flag: Myanmar (Burma)",
            },
            {
                emoji: "ðŸ‡²ðŸ‡³",
                title: "Flag: Mongolia",
            },
            {
                emoji: "ðŸ‡²ðŸ‡´",
                title: "Flag: Macao Sar China",
            },
            {
                emoji: "ðŸ‡²ðŸ‡µ",
                title: "Flag: Northern Mariana Islands",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¶",
                title: "Flag: Martinique",
            },
            {
                emoji: "ðŸ‡²ðŸ‡·",
                title: "Flag: Mauritania",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¸",
                title: "Flag: Montserrat",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¹",
                title: "Flag: Malta",
            },
            {
                emoji: "ðŸ‡²ðŸ‡º",
                title: "Flag: Mauritius",
            },
            {
                emoji: "ðŸ‡²ðŸ‡»",
                title: "Flag: Maldives",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¼",
                title: "Flag: Malawi",
            },
            {
                emoji: "ðŸ‡²ðŸ‡½",
                title: "Flag: Mexico",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¾",
                title: "Flag: Malaysia",
            },
            {
                emoji: "ðŸ‡²ðŸ‡¿",
                title: "Flag: Mozambique",
            },
            {
                emoji: "ðŸ‡³ðŸ‡¦",
                title: "Flag: Namibia",
            },
            {
                emoji: "ðŸ‡³ðŸ‡¨",
                title: "Flag: New Caledonia",
            },
            {
                emoji: "ðŸ‡³ðŸ‡ª",
                title: "Flag: Niger",
            },
            {
                emoji: "ðŸ‡³ðŸ‡«",
                title: "Flag: Norfolk Island",
            },
            {
                emoji: "ðŸ‡³ðŸ‡¬",
                title: "Flag: Nigeria",
            },
            {
                emoji: "ðŸ‡³ðŸ‡®",
                title: "Flag: Nicaragua",
            },
            {
                emoji: "ðŸ‡³ðŸ‡±",
                title: "Flag: Netherlands",
            },
            {
                emoji: "ðŸ‡³ðŸ‡´",
                title: "Flag: Norway",
            },
            {
                emoji: "ðŸ‡³ðŸ‡µ",
                title: "Flag: Nepal",
            },
            {
                emoji: "ðŸ‡³ðŸ‡·",
                title: "Flag: Nauru",
            },
            {
                emoji: "ðŸ‡³ðŸ‡º",
                title: "Flag: Niue",
            },
            {
                emoji: "ðŸ‡³ðŸ‡¿",
                title: "Flag: New Zealand",
            },
            {
                emoji: "ðŸ‡´ðŸ‡²",
                title: "Flag: Oman",
            },
            {
                emoji: "ðŸ‡µðŸ‡¦",
                title: "Flag: Panama",
            },
            {
                emoji: "ðŸ‡µðŸ‡ª",
                title: "Flag: Peru",
            },
            {
                emoji: "ðŸ‡µðŸ‡«",
                title: "Flag: French Polynesia",
            },
            {
                emoji: "ðŸ‡µðŸ‡¬",
                title: "Flag: Papua New Guinea",
            },
            {
                emoji: "ðŸ‡µðŸ‡­",
                title: "Flag: Philippines",
            },
            {
                emoji: "ðŸ‡µðŸ‡°",
                title: "Flag: Pakistan",
            },
            {
                emoji: "ðŸ‡µðŸ‡±",
                title: "Flag: Poland",
            },
            {
                emoji: "ðŸ‡µðŸ‡²",
                title: "Flag: St. Pierre & Miquelon",
            },
            {
                emoji: "ðŸ‡µðŸ‡³",
                title: "Flag: Pitcairn Islands",
            },
            {
                emoji: "ðŸ‡µðŸ‡·",
                title: "Flag: Puerto Rico",
            },
            {
                emoji: "ðŸ‡µðŸ‡¸",
                title: "Flag: Palestinian Territories",
            },
            {
                emoji: "ðŸ‡µðŸ‡¹",
                title: "Flag: Portugal",
            },
            {
                emoji: "ðŸ‡µðŸ‡¼",
                title: "Flag: Palau",
            },
            {
                emoji: "ðŸ‡µðŸ‡¾",
                title: "Flag: Paraguay",
            },
            {
                emoji: "ðŸ‡¶ðŸ‡¦",
                title: "Flag: Qatar",
            },
            {
                emoji: "ðŸ‡·ðŸ‡ª",
                title: "Flag: RÃ©union",
            },
            {
                emoji: "ðŸ‡·ðŸ‡´",
                title: "Flag: Romania",
            },
            {
                emoji: "ðŸ‡·ðŸ‡¸",
                title: "Flag: Serbia",
            },
            {
                emoji: "ðŸ‡·ðŸ‡º",
                title: "Flag: Russia",
            },
            {
                emoji: "ðŸ‡·ðŸ‡¼",
                title: "Flag: Rwanda",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¦",
                title: "Flag: Saudi Arabia",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡§",
                title: "Flag: Solomon Islands",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¨",
                title: "Flag: Seychelles",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡©",
                title: "Flag: Sudan",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡ª",
                title: "Flag: Sweden",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¬",
                title: "Flag: Singapore",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡­",
                title: "Flag: St. Helena",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡®",
                title: "Flag: Slovenia",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¯",
                title: "Flag: Svalbard & Jan Mayen",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡°",
                title: "Flag: Slovakia",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡±",
                title: "Flag: Sierra Leone",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡²",
                title: "Flag: San Marino",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡³",
                title: "Flag: Senegal",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡´",
                title: "Flag: Somalia",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡·",
                title: "Flag: Suriname",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¸",
                title: "Flag: South Sudan",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¹",
                title: "Flag: SÃ£o TomÃ© & PrÃ­ncipe",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡»",
                title: "Flag: El Salvador",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡½",
                title: "Flag: Sint Maarten",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¾",
                title: "Flag: Syria",
            },
            {
                emoji: "ðŸ‡¸ðŸ‡¿",
                title: "Flag: Eswatini",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡¦",
                title: "Flag: Tristan Da Cunha",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡¨",
                title: "Flag: Turks & Caicos Islands",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡©",
                title: "Flag: Chad",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡«",
                title: "Flag: French Southern Territories",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡¬",
                title: "Flag: Togo",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡­",
                title: "Flag: Thailand",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡¯",
                title: "Flag: Tajikistan",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡°",
                title: "Flag: Tokelau",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡±",
                title: "Flag: Timor-Leste",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡²",
                title: "Flag: Turkmenistan",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡³",
                title: "Flag: Tunisia",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡´",
                title: "Flag: Tonga",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡·",
                title: "Flag: Turkey",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡¹",
                title: "Flag: Trinidad & Tobago",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡»",
                title: "Flag: Tuvalu",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡¼",
                title: "Flag: Taiwan",
            },
            {
                emoji: "ðŸ‡¹ðŸ‡¿",
                title: "Flag: Tanzania",
            },
            {
                emoji: "ðŸ‡ºðŸ‡¦",
                title: "Flag: Ukraine",
            },
            {
                emoji: "ðŸ‡ºðŸ‡¬",
                title: "Flag: Uganda",
            },
            {
                emoji: "ðŸ‡ºðŸ‡²",
                title: "Flag: U.S. Outlying Islands",
            },
            {
                emoji: "ðŸ‡ºðŸ‡³",
                title: "Flag: United Nations",
            },
            {
                emoji: "ðŸ‡ºðŸ‡¸",
                title: "Flag: United States",
            },
            {
                emoji: "ðŸ‡ºðŸ‡¾",
                title: "Flag: Uruguay",
            },
            {
                emoji: "ðŸ‡ºðŸ‡¿",
                title: "Flag: Uzbekistan",
            },
            {
                emoji: "ðŸ‡»ðŸ‡¦",
                title: "Flag: Vatican City",
            },
            {
                emoji: "ðŸ‡»ðŸ‡¨",
                title: "Flag: St. Vincent & Grenadines",
            },
            {
                emoji: "ðŸ‡»ðŸ‡ª",
                title: "Flag: Venezuela",
            },
            {
                emoji: "ðŸ‡»ðŸ‡¬",
                title: "Flag: British Virgin Islands",
            },
            {
                emoji: "ðŸ‡»ðŸ‡®",
                title: "Flag: U.S. Virgin Islands",
            },
            {
                emoji: "ðŸ‡»ðŸ‡³",
                title: "Flag: Vietnam",
            },
            {
                emoji: "ðŸ‡»ðŸ‡º",
                title: "Flag: Vanuatu",
            },
            {
                emoji: "ðŸ‡¼ðŸ‡«",
                title: "Flag: Wallis & Futuna",
            },
            {
                emoji: "ðŸ‡¼ðŸ‡¸",
                title: "Flag: Samoa",
            },
            {
                emoji: "ðŸ‡½ðŸ‡°",
                title: "Flag: Kosovo",
            },
            {
                emoji: "ðŸ‡¾ðŸ‡ª",
                title: "Flag: Yemen",
            },
            {
                emoji: "ðŸ‡¾ðŸ‡¹",
                title: "Flag: Mayotte",
            },
            {
                emoji: "ðŸ‡¿ðŸ‡¦",
                title: "Flag: South Africa",
            },
            {
                emoji: "ðŸ‡¿ðŸ‡²",
                title: "Flag: Zambia",
            },
            {
                emoji: "ðŸ‡¿ðŸ‡¼",
                title: "Flag: Zimbabwe",
            },
            {
                emoji: "ðŸ´ó §ó ¢ó ¥ó ®ó §ó ¿",
                title: "Flag: England",
            },
            {
                emoji: "ðŸ´ó §ó ¢ó ³ó £ó ´ó ¿",
                title: "Flag: Scotland",
            },
            {
                emoji: "ðŸ´ó §ó ¢ó ·ó ¬ó ³ó ¿",
                title: "Flag: Wales",
            },
            {
                emoji: "ðŸ´ó µó ³ó ´ó ¸ó ¿",
                title: "Flag for Texas (US-TX)",
            },
        ],
    };

    const categoryFlags = {
        People:
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g> <path d="M437.02,74.98C388.667,26.629,324.38,0,256,0S123.333,26.629,74.98,74.98C26.629,123.333,0,187.62,0,256 s26.629,132.668,74.98,181.02C123.333,485.371,187.62,512,256,512s132.667-26.629,181.02-74.98 C485.371,388.668,512,324.38,512,256S485.371,123.333,437.02,74.98z M256,472c-119.103,0-216-96.897-216-216S136.897,40,256,40 s216,96.897,216,216S375.103,472,256,472z"/> </g> </g> <g> <g> <path d="M368.993,285.776c-0.072,0.214-7.298,21.626-25.02,42.393C321.419,354.599,292.628,368,258.4,368 c-34.475,0-64.195-13.561-88.333-40.303c-18.92-20.962-27.272-42.54-27.33-42.691l-37.475,13.99 c0.42,1.122,10.533,27.792,34.013,54.273C171.022,389.074,212.215,408,258.4,408c46.412,0,86.904-19.076,117.099-55.166 c22.318-26.675,31.165-53.55,31.531-54.681L368.993,285.776z"/> </g> </g> <g> <g> <circle cx="168" cy="180.12" r="32"/> </g> </g> <g> <g> <circle cx="344" cy="180.12" r="32"/> </g> </g> <g> </g> <g> </g> <g> </g> </svg>',
        Nature:
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 354.968 354.968" style="enable-background:new 0 0 354.968 354.968;" xml:space="preserve"> <g> <g> <path d="M350.775,341.319c-9.6-28.4-20.8-55.2-34.4-80.8c0.4-0.4,0.8-1.2,1.6-1.6c30.8-34.8,44-83.6,20.4-131.6 c-20.4-41.6-65.6-76.4-124.8-98.8c-57.2-22-127.6-32.4-200.4-27.2c-5.6,0.4-10,5.2-9.6,10.8c0.4,2.8,1.6,5.6,4,7.2 c36.8,31.6,50,79.2,63.6,126.8c8,28,15.6,55.6,28.4,81.2c0,0.4,0.4,0.4,0.4,0.8c30.8,59.6,78,81.2,122.8,78.4 c18.4-1.2,36-6.4,52.4-14.4c9.2-4.8,18-10.4,26-16.8c11.6,23.2,22,47.2,30.4,72.8c1.6,5.2,7.6,8,12.8,6.4 C349.975,352.119,352.775,346.519,350.775,341.319z M271.175,189.319c-34.8-44.4-78-82.4-131.6-112.4c-4.8-2.8-11.2-1.2-13.6,4 c-2.8,4.8-1.2,11.2,4,13.6c50.8,28.8,92.4,64.8,125.6,107.2c13.2,17.2,25.2,35.2,36,54c-8,7.6-16.4,13.6-25.6,18 c-14,7.2-28.8,11.6-44.4,12.4c-37.6,2.4-77.2-16-104-67.6v-0.4c-11.6-24-19.2-50.8-26.8-78c-12.4-43.2-24.4-86.4-53.6-120.4 c61.6-1.6,120.4,8.4,169.2,27.2c54.4,20.8,96,52,114,88.8c18.8,38,9.2,76.8-14.4,105.2 C295.575,222.919,283.975,205.719,271.175,189.319z"/> </g> </g> <g> </g> <g> </g> <g> </g> </svg>',
        "Food-dring":
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 295 295" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 295 295"> <g> <path d="M25,226.011v16.511c0,8.836,7.465,16.489,16.302,16.489h214.063c8.837,0,15.636-7.653,15.636-16.489v-16.511H25z"/> <path d="m271.83,153.011c-3.635-66-57.634-117.022-123.496-117.022-65.863,0-119.863,51.021-123.498,117.022h246.994zm-198.497-50.99c-4.557,0-8.25-3.693-8.25-8.25 0-4.557 3.693-8.25 8.25-8.25 4.557,0 8.25,3.693 8.25,8.25 0,4.557-3.693,8.25-8.25,8.25zm42,33c-4.557,0-8.25-3.693-8.25-8.25 0-4.557 3.693-8.25 8.25-8.25 4.557,0 8.25,3.693 8.25,8.25 0,4.557-3.693,8.25-8.25,8.25zm33.248-58c-4.557,0-8.25-3.693-8.25-8.25 0-4.557 3.693-8.25 8.25-8.25 4.557,0 8.25,3.693 8.25,8.25 0,4.557-3.693,8.25-8.25,8.25zm32.752,58c-4.557,0-8.25-3.693-8.25-8.25 0-4.557 3.693-8.25 8.25-8.25 4.557,0 8.25,3.693 8.25,8.25 0,4.557-3.693,8.25-8.25,8.25zm50.25-41.25c0,4.557-3.693,8.25-8.25,8.25-4.557,0-8.25-3.693-8.25-8.25 0-4.557 3.693-8.25 8.25-8.25 4.557,0 8.25,3.694 8.25,8.25z"/> <path d="m275.414,169.011h-0.081-254.825c-11.142,0-20.508,8.778-20.508,19.921v0.414c0,11.143 9.366,20.665 20.508,20.665h254.906c11.142,0 19.586-9.523 19.586-20.665v-0.414c0-11.143-8.444-19.921-19.586-19.921z"/> </g> </svg>',
        Activity:
            '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path id="XMLID_272_" d="m437.02 74.98c-48.353-48.351-112.64-74.98-181.02-74.98s-132.667 26.629-181.02 74.98c-48.351 48.353-74.98 112.64-74.98 181.02s26.629 132.667 74.98 181.02c48.353 48.351 112.64 74.98 181.02 74.98s132.667-26.629 181.02-74.98c48.351-48.353 74.98-112.64 74.98-181.02s-26.629-132.667-74.98-181.02zm-407.02 181.02c0-57.102 21.297-109.316 56.352-149.142 37.143 45.142 57.438 101.499 57.438 160.409 0 53.21-16.914 105.191-47.908 148.069-40.693-40.891-65.882-97.226-65.882-159.336zm88.491 179.221c35.75-48.412 55.3-107.471 55.3-167.954 0-66.866-23.372-130.794-66.092-181.661 39.718-34.614 91.603-55.606 148.301-55.606 56.585 0 108.376 20.906 148.064 55.396-42.834 50.9-66.269 114.902-66.269 181.872 0 60.556 19.605 119.711 55.448 168.158-38.077 29.193-85.665 46.574-137.243 46.574-51.698 0-99.388-17.461-137.509-46.779zm297.392-19.645c-31.104-42.922-48.088-95.008-48.088-148.309 0-59.026 20.367-115.47 57.638-160.651 35.182 39.857 56.567 92.166 56.567 149.384 0 62.23-25.284 118.665-66.117 159.576z"/></svg>',
        "Travel-places":
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"> <g><g><path d="M846.5,153.5C939,246.1,990,369.1,990,500c0,130.9-51,253.9-143.5,346.5C753.9,939,630.9,990,500,990c-130.9,0-253.9-51-346.5-143.5C61,753.9,10,630.9,10,500c0-130.9,51-253.9,143.5-346.5C246.1,61,369.1,10,500,10C630.9,10,753.9,61,846.5,153.5z M803.2,803.2c60.3-60.3,100.5-135.5,117-217.3c-12.9,19-25.2,26-32.9-16.5c-7.9-69.3-71.5-25-111.5-49.6c-42.1,28.4-136.8-55.2-120.7,39.1c24.8,42.5,134-56.9,79.6,33.1c-34.7,62.8-126.9,201.9-114.9,274c1.5,105-107.3,21.9-144.8-12.9c-25.2-69.8-8.6-191.8-74.6-225.9c-71.6-3.1-133-9.6-160.8-89.6c-16.7-57.3,17.8-142.5,79.1-155.7c89.8-56.4,121.9,66.1,206.1,68.4c26.2-27.4,97.4-36.1,103.4-66.8c-55.3-9.8,70.1-46.5-5.3-67.4c-41.6,4.9-68.4,43.1-46.3,75.6C496,410.3,493.5,274.8,416,317.6c-2,67.6-126.5,21.9-43.1,8.2c28.7-12.5-46.8-48.8-6-42.2c20-1.1,87.4-24.7,69.2-40.6c37.5-23.3,69.1,55.8,105.8-1.8c26.5-44.3-11.1-52.5-44.4-30c-18.7-21,33.1-66.3,78.8-85.9c15.2-6.5,29.8-10.1,40.9-9.1c23,26.6,65.6,31.2,67.8-3.2c-57-27.3-119.9-41.7-185-41.7c-93.4,0-182.3,29.7-255.8,84.6c19.8,9.1,31,20.3,11.9,34.7c-14.8,44.1-74.8,103.2-127.5,94.9c-27.4,47.2-45.4,99.2-53.1,153.6c44.1,14.6,54.3,43.5,44.8,53.2c-22.5,19.6-36.3,47.4-43.4,77.8C91.3,658,132.6,739,196.8,803.2c81,81,188.6,125.6,303.2,125.6C614.5,928.8,722.2,884.2,803.2,803.2z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></g> </svg>',
        Objects:
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 461.977 461.977" style="enable-background:new 0 0 461.977 461.977;" xml:space="preserve"> <g> <path d="M398.47,248.268L346.376,18.543C344.136,8.665,333.287,0,323.158,0H138.821c-10.129,0-20.979,8.665-23.219,18.543 L63.507,248.268c-0.902,3.979-0.271,7.582,1.775,10.145c2.047,2.564,5.421,3.975,9.501,3.975h51.822v39.108 c-6.551,3.555-11,10.493-11,18.47c0,11.598,9.402,21,21,21c11.598,0,21-9.402,21-21c0-7.978-4.449-14.916-11-18.47v-39.108h240.587 c4.079,0,7.454-1.412,9.501-3.975C398.742,255.849,399.372,252.247,398.47,248.268z"/> <path d="M318.735,441.977h-77.747V282.388h-20v159.588h-77.747c-5.523,0-10,4.477-10,10c0,5.523,4.477,10,10,10h175.494 c5.522,0,10-4.477,10-10C328.735,446.454,324.257,441.977,318.735,441.977z"/> </g> <g> </g> <g> </g> <g> </g> </svg>',
        Symbols:
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30.487 30.486" style="enable-background:new 0 0 30.487 30.486;" xml:space="preserve"> <g> <path d="M28.866,17.477h-2.521V15.03h-2.56c0.005-2.8-0.304-5.204-0.315-5.308l-0.088-0.67L22.75,8.811 c-0.021-0.008-0.142-0.051-0.317-0.109l2.287-8.519L19,4.836L15.23,0.022V0l-0.009,0.01L15.215,0v0.021l-3.769,4.815L5.725,0.183 l2.299,8.561c-0.157,0.051-0.268,0.09-0.288,0.098L7.104,9.084l-0.088,0.67c-0.013,0.104-0.321,2.508-0.316,5.308h-2.56v2.446H1.62 l0.447,2.514L1.62,22.689h6.474c1.907,2.966,5.186,7.549,7.162,7.797v-0.037c1.979-0.283,5.237-4.838,7.137-7.79h6.474l-0.447-2.67 L28.866,17.477z M21.137,20.355c-0.422,1.375-4.346,6.949-5.907,7.758v0.015c-1.577-0.853-5.461-6.373-5.882-7.739 c-0.002-0.043-0.005-0.095-0.008-0.146l11.804-0.031C21.141,20.264,21.139,20.314,21.137,20.355z M8.972,15.062 c-0.003-1.769,0.129-3.403,0.219-4.298c0.98-0.271,3.072-0.723,6.065-0.78v-0.03c2.979,0.06,5.063,0.51,6.04,0.779 c0.09,0.895,0.223,2.529,0.219,4.298L8.972,15.062z"/> </g> <g> </g> <g> </g> <g> </g> </svg>',
        Flags:
            '<svg viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" fill-rule="evenodd"><g id="037---Waypoint-Flag" fill-rule="nonzero" transform="translate(0 -1)"><path id="Shape" d="m59.0752 28.5054c-3.7664123-1.873859-7.2507049-4.2678838-10.3506-7.1118 1.5923634-6.0211307 2.7737841-12.14349669 3.5361-18.3248.1788-1.44-.623-1.9047-.872-2.0126-.7016942-.26712004-1.4944908-.00419148-1.8975.6293-5.4726 6.5479-12.9687 5.8008-20.9053 5.0054-7.9985-.8-16.2506-1.6116-22.3684 5.4114-.85552122-1.067885-2.26533581-1.5228479-3.5837-1.1565l-.1377.0386c-1.81412367.5095218-2.87378593 2.391025-2.3691 4.2065l12.2089 43.6891c.3541969 1.2645215 1.5052141 2.1399137 2.8184 2.1435.2677318-.0003961.5341685-.0371657.792-.1093l1.0683-.2984h.001c.7485787-.2091577 1.3833789-.7071796 1.7646969-1.3844635.381318-.677284.4779045-1.478326.2685031-2.2268365l-3.7812-13.5327c5.5066-7.0807 13.18-6.3309 21.2988-5.52 8.1094.81 16.4863 1.646 22.64-5.7129l.0029-.0039c.6044387-.7534187.8533533-1.7315007.6826-2.6822-.0899994-.4592259-.3932698-.8481635-.8167-1.0474zm-42.0381 29.7446c-.1201754.2157725-.3219209.3742868-.56.44l-1.0684.2983c-.4949157.1376357-1.0078362-.1513714-1.1465-.646l-12.2095-43.6895c-.20840349-.7523825.23089143-1.5316224.9825-1.7428l.1367-.0381c.12366014-.0348192.25153137-.0524183.38-.0523.63429117.0010181 1.19083557.4229483 1.3631 1.0334l.1083.3876v.0021l6.2529 22.3755 5.8468 20.9238c.0669515.2380103.0360256.4929057-.0859.708zm40.6329-27.2925c-5.4736 6.5459-12.9707 5.7974-20.9043 5.0039-7.9033-.79-16.06-1.605-22.1552 5.1558l-5.463-19.548-2.0643-7.3873c5.5068-7.0794 13.1796-6.3119 21.3045-5.5007 7.7148.7695 15.6787 1.5664 21.7373-4.7095-.7467138 5.70010904-1.859683 11.3462228-3.332 16.9033-.1993066.7185155.0267229 1.4878686.583 1.9844 3.1786296 2.9100325 6.7366511 5.3762694 10.5771 7.3315-.0213812.2768572-.1194065.5422977-.2831.7666z"/></g></g></svg>',
    };

    const icons = {
        search:
            '<svg style="fill: #646772;" version="1.1" width="17" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 487.95 487.95" style="enable-background:new 0 0 487.95 487.95;" xml:space="preserve"> <g> <g> <path d="M481.8,453l-140-140.1c27.6-33.1,44.2-75.4,44.2-121.6C386,85.9,299.5,0.2,193.1,0.2S0,86,0,191.4s86.5,191.1,192.9,191.1 c45.2,0,86.8-15.5,119.8-41.4l140.5,140.5c8.2,8.2,20.4,8.2,28.6,0C490,473.4,490,461.2,481.8,453z M41,191.4 c0-82.8,68.2-150.1,151.9-150.1s151.9,67.3,151.9,150.1s-68.2,150.1-151.9,150.1S41,274.1,41,191.4z"/> </g> </g> <g> </g> <g> </g> </svg>',
        close:
            '<svg style="height: 11px !important;" viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg"><path d="M28.94,26,51.39,3.55A2.08,2.08,0,0,0,48.45.61L26,23.06,3.55.61A2.08,2.08,0,0,0,.61,3.55L23.06,26,.61,48.45A2.08,2.08,0,0,0,2.08,52a2.05,2.05,0,0,0,1.47-.61L26,28.94,48.45,51.39a2.08,2.08,0,0,0,2.94-2.94Z"/></svg>',
        move: '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.006 512.006" xml:space="preserve"> <g> <g> <path d="M508.247,246.756l-72.457-72.465c-5.009-5.009-13.107-5.009-18.116,0c-5.009,5.009-5.009,13.107,0,18.116l50.594,50.594 H268.811V43.748l50.594,50.594c5.009,5.009,13.107,5.009,18.116,0c5.009-5.009,5.009-13.107,0-18.116L265.056,3.761 c-5.001-5.009-13.107-5.009-18.116,0l-72.457,72.457c-5.009,5.009-5.009,13.107,0,18.116c5.001,5.009,13.107,5.009,18.116,0 l50.594-50.594v199.27H43.744l50.594-50.594c5.009-5.009,5.009-13.107,0-18.116c-5.009-5.009-13.107-5.009-18.116,0L3.757,246.756 c-5.009,5.001-5.009,13.107,0,18.116l72.465,72.457c5.009,5.009,13.107,5.009,18.116,0c5.009-5.001,5.009-13.107,0-18.116 l-50.594-50.594h199.458v199.646l-50.594-50.594c-5.009-5.001-13.107-5.001-18.116,0c-5.009,5.009-5.009,13.107,0,18.116 l72.457,72.465c5,5,13.107,5,18.116,0l72.465-72.457c5.009-5.009,5.009-13.107,0-18.116c-5.009-5-13.107-5-18.116,0 l-50.594,50.594V268.627h199.458l-50.594,50.594c-5.009,5.009-5.009,13.107,0,18.116s13.107,5.009,18.116,0l72.465-72.457 C513.257,259.872,513.257,251.765,508.247,246.756z"/> </g> </g> <g> </g> </svg>',
    };

    const functions = {
        styles: () => {
            const styles = `
                <style>
                    .fg-emoji-container {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: ${pickerWidth}px;
                        height: ${pickerHeight}px;
                        border-radius: 5px;
                        box-shadow: 0px 3px 20px 0px rgba(0, 0, 0, 0.62);
                        background-color: white;
                        overflow: hidden;
                        z-index: 9999;
                    }

                    .fg-emoji-container svg {
                        max-width: 100%;
                        box-sizing: border-box;
                        width: 15px;
                        height: 15px;
                    }

                    .fg-emoji-picker-category-title {
                        display: block;
                        margin: 20px 0 0 0;
                        padding: 0 10px 5px 10px;
                        font-size: 16px;
                        font-family: sans-serif;
                        font-weight: bold;
                        flex: 0 0 calc(100% - 20px);
                        border-bottom: 1px solid #ededed;
                    }

                    .fg-emoji-nav {
                        background-color: #646772;
                    }

                    .fg-emoji-nav li a svg {
                        transition: all .2s ease;
                        fill: white;
                    }

                    .fg-emoji-nav li:hover a svg {
                        fill: black;
                    }

                    .fg-emoji-nav ul {
                        display: flex;
                        flex-wrap: wrap;
                        list-style: none;
                        margin: 0;
                        padding: 0;
                        border-bottom: 1px solid #dbdbdb;
                    }

                    .fg-emoji-nav ul li {
                        flex: 1;
                    }

                    .fg-emoji-nav ul li a {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 40px;
                        transition: all .2s ease;
                    }

                    .fg-emoji-nav ul li a:hover {
                        background-color: #e9ebf1;
                    }

                    .fg-emoji-nav ul li.active a {
                        background-color: #e9ebf1;
                    }

                    .fg-emoji-nav ul li.emoji-picker-nav-active a {
                        background-color: #e9ebf1;
                    }

                    .fg-emoji-nav ul li.emoji-picker-nav-active a svg {
                        fill: #646772;
                    }

                    .fg-emoji-picker-move {
                        /* pointer-events: none; */
                        cursor: move;
                    }

                    .fg-picker-special-buttons a {
                        background-color: ${
                this.options.specialButtons
                    ? this.options.specialButtons
                    : "#ed5e28"
            };
                    }

                    .fg-picker-special-buttons:last-child a {
                        box-shadow: inset 1px 0px 0px 0 rgba(0, 0, 0, 0.11);
                    }

                    .fg-emoji-list {
                        list-style: none;
                        margin: 0;
                        padding: 0;
                        overflow-y: scroll;
                        overflow-x: hidden;
                        height: 323px;
                    }

                    .fg-emoji-picker-category-wrapper {
                        display: flex;
                        flex-wrap: wrap;
                        flex: 1;
                    }

                    .fg-emoji-list li {
                        position: relative;
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                        align-items: center;
                        flex: 0 0 calc(100% / 6);
                        height: 50px;
                    }

                    .fg-emoji-list li a {
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        text-decoration: none;
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                        align-items: center;
                        font-size: 23px;
                        background-color: #ffffff;
                        border-radius: 3px;
                        transition: all .3s ease;
                    }
                    
                    .fg-emoji-list li a:hover {
                        background-color: #ebebeb;
                    }

                    .fg-emoji-picker-search {
                        position: relative;
                    }

                    .fg-emoji-picker-search input {
                        border: none;
                        box-shadow: 0 0 0 0;
                        outline: none;
                        width: calc(100% - 30px);
                        display: block;
                        padding: 10px 15px;
                        background-color: #f3f3f3;
                    }

                    .fg-emoji-picker-search .fg-emoji-picker-search-icon {
                        position: absolute;
                        right: 0;
                        top: 0;
                        width: 40px;
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                </style>
            `;

            document.head.insertAdjacentHTML("beforeend", styles);
        },

        position: () => {
            const e = window.event;
            const clickPosX = e.clientX;
            const clickPosY = e.clientY;
            const obj = {};

            obj.left = clickPosX;
            obj.top = clickPosY;

            return obj;
        },

        rePositioning: (picker) => {
            picker.getBoundingClientRect().right > window.screen.availWidth
                ? (picker.style.left =
                    window.screen.availWidth - picker.offsetWidth + "px")
                : false;

            if (window.innerHeight > pickerHeight) {
                picker.getBoundingClientRect().bottom > window.innerHeight
                    ? (picker.style.top = window.innerHeight - picker.offsetHeight + "px")
                    : false;
            }
        },

        render: (e, attr) => {
            emojiList = undefined;

            const index = this.options.trigger.findIndex(
                (item) => item.selector === attr
            );
            this.insertInto = this.options.trigger[index].insertInto;

            const position = functions.position();

            if (!emojiesHTML.length) {
                for (const key in emojiObj) {
                    if (emojiObj.hasOwnProperty.call(emojiObj, key)) {
                        const categoryObj = emojiObj[key];

                        categoriesHTML += `<li>
                            <a title="${key}" href="#${key}">${categoryFlags[key]}</a>
                        </li>`;

                        emojiesHTML += `<div class="fg-emoji-picker-category-wrapper" id="${key}">`;
                        emojiesHTML += `<p class="fg-emoji-picker-category-title">${key}</p>`;
                        categoryObj.forEach((ej) => {
                            emojiesHTML += `<li data-title="${ej.title.toLowerCase()}">
                                    <a title="${ej.title}" href="#">${
                                ej.emoji
                            }</a>
                                </li>`;
                        });
                        emojiesHTML += "</div>";
                    }
                }
            }

            if (document.querySelector(".fg-emoji-container")) {
                this.lib(".fg-emoji-container").remove();
            }

            const picker = `
                <div class="fg-emoji-container" style="left: ${
                position.left
            }px; top: ${position.top}px;">
                    <nav class="fg-emoji-nav">
                        <ul>
                            ${categoriesHTML}

                            <li class="fg-picker-special-buttons" id="fg-emoji-picker-move"><a class="fg-emoji-picker-move" href="#">${
                icons.move
            }</a></li>
                            ${
                this.options.closeButton
                    ? `<li class="fg-picker-special-buttons"><a id="fg-emoji-picker-close-button" href="#">` +
                    icons.close +
                    `</a></li>`
                    : ""
            }
                        </ul>
                    </nav>

                    <div class="fg-emoji-picker-search">
                        <input type="text" placeholder="Search" autofocus />
                        
                        <span class="fg-emoji-picker-search-icon">${
                icons.search
            }</sapn>
                    </div>

                    <div>
                        <!--<div class="fg-emoji-picker-loader-animation">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>-->

                        <ul class="fg-emoji-list">
                            ${emojiesHTML}
                        </ul>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML("beforeend", picker);

            functions.rePositioning(document.querySelector(".fg-emoji-container"));

            setTimeout(() => {
                document.querySelector(".fg-emoji-picker-search input").focus();
            }, 500);
        },

        closePicker: (e) => {
            e.preventDefault();

            this.lib(".fg-emoji-container").remove();

            moseMove = false;
        },

        checkPickerExist(e) {
            if (
                document.querySelector(".fg-emoji-container") &&
                !e.target.closest(".fg-emoji-container") &&
                !moseMove
            ) {
                functions.closePicker.call(this, e);
            }
        },

        setCaretPosition: (field, caretPos) => {
            var elem = field;
            if (elem != null) {
                if (elem.createTextRange) {
                    var range = elem.createTextRange();
                    range.move("character", caretPos);
                    range.select();
                } else {
                    if (elem.selectionStart) {
                        elem.focus();
                        elem.setSelectionRange(caretPos, caretPos);
                    } else {
                        elem.focus();
                    }
                }
            }
        },

        insert: (e) => {
            e.preventDefault();

            const emoji = e.target.innerText.trim();
            const myField = document.querySelectorAll(this.insertInto);
            const myValue = emoji;

            // Check if selector is an array
            myField.forEach((myField) => {
                if (document.selection) {
                    myField.focus();
                    sel = document.selection.createRange();
                    sel.text = myValue;
                } else if (myField.selectionStart || myField.selectionStart == "0") {
                    const startPos = myField.selectionStart;
                    const endPos = myField.selectionEnd;
                    myField.value =
                        myField.value.substring(0, startPos) +
                        myValue +
                        myField.value.substring(endPos, myField.value.length);

                    functions.setCaretPosition(myField, startPos + 2);
                } else {
                    myField.value += myValue;
                    myField.focus();
                }
            });
        },

        categoryNav: (e) => {
            e.preventDefault();

            const link = e.target.closest("a");

            if (
                link.getAttribute("id") &&
                link.getAttribute("id") === "fg-emoji-picker-close-button"
            )
                return false;
            if (link.className.includes("fg-emoji-picker-move")) return false;

            const id = link.getAttribute("href");
            const emojiBody = document.querySelector(".fg-emoji-list");
            const destination = emojiBody.querySelector(`${id}`);

            this.lib(".fg-emoji-nav li").removeClass("emoji-picker-nav-active");
            link.closest("li").classList.add("emoji-picker-nav-active");

            destination.scrollIntoView({
                behavior: "smooth",
                block: "start",
                inline: "nearest",
            });
        },

        search: (e) => {
            const val = e.target.value.trim();

            if (!emojiList) {
                emojiList = Array.from(
                    document.querySelectorAll(".fg-emoji-picker-category-wrapper li")
                );
            }

            emojiList.filter((emoji) => {
                if (!emoji.getAttribute("data-title").match(val)) {
                    emoji.style.display = "none";
                } else {
                    emoji.style.display = "";
                }
            });
        },

        mouseDown: (e) => {
            e.preventDefault();
            moseMove = true;
        },

        mouseUp: (e) => {
            e.preventDefault();
            moseMove = false;
        },

        mouseMove: (e) => {
            if (moseMove) {
                e.preventDefault();
                const el = document.querySelector(".fg-emoji-container");
                el.style.left = e.clientX - 320 + "px";
                el.style.top = e.clientY - 10 + "px";
            }
        },
    };

    const bindEvents = () => {
        this.lib(document.body).on(
            "click",
            functions.closePicker,
            "#fg-emoji-picker-close-button"
        );
        this.lib(document.body).on("click", functions.checkPickerExist);
        this.lib(document.body).on("click", functions.render, this.trigger);
        this.lib(document.body).on("click", functions.insert, ".fg-emoji-list a");
        this.lib(document.body).on(
            "click",
            functions.categoryNav,
            ".fg-emoji-nav a"
        );
        this.lib(document.body).on(
            "input",
            functions.search,
            ".fg-emoji-picker-search input"
        );
        this.lib(document).on(
            "mousedown",
            functions.mouseDown,
            "#fg-emoji-picker-move"
        );
        this.lib(document).on(
            "mouseup",
            functions.mouseUp,
            "#fg-emoji-picker-move"
        );
        this.lib(document).on("mousemove", functions.mouseMove);
    };

    (() => {
        // Start styles
        functions.styles();

        // Event functions
        bindEvents.call(this);
    })();
};