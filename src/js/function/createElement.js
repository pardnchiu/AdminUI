const regexCssClass = /\.([\w_-]+)?/gi;
const regexCssID = /\#([\w_-]+)?/i;
const regexCssTag = /^\w+(?=[\#\.]*)/i;

function createElement(tag = "", val0, val1) {
    const cssTag = ((tag.match(regexCssTag) || [])[0] || "").trim();
    const cssID = ((tag.match(regexCssID) || [])[1] || "").trim();
    const cssClass = (regexCssClass.test(tag) ? tag.match(regexCssClass) : []).map(e => e.replace(/^\./, ""));

    if (cssTag.length < 1) {
        return;
    };

    let isTemp = tag === "temp";
    let dom = isTemp
        ? document.createDocumentFragment()
        : document.createElement(cssTag);

    if (cssID.length > 0) {
        dom.id = cssID;
    };

    for (const e of cssClass) {
        dom.classList.add(e);
    };

    if (val0 == null && val1 != null) {
        [val0, val1] = [val1, null];
    };

    let attributeValue;
    let childrenValue;

    if (val0 != null && val1 != null) {
        [attributeValue, childrenValue] = [val0, val1];
    }
    else if (val1 == null) {
        if (typeof val0 === "string" || typeof val0 === "number" || Array.isArray(val0)) {
            childrenValue = val0;
        }
        else {
            attributeValue = val0;
        };
    }
    else if (val0 == null) {
        return dom;
    };

    // * 設定屬性值
    (_ => {
        if (typeof attributeValue !== "object" || attributeValue == null) {
            return;
        };

        for (const e in attributeValue) {
            if (!attributeValue.hasOwnProperty(e)) {
                continue;
            };

            const value = attributeValue[e];

            if ({
                value: 1,
                innerText: 1,
                innerHTML: 1,
                textContent: 1,
                contentEditable: 1,
                selected: 1,
                checked: 1
            }[e]) {
                dom[e] = value;
            }
            else if ({
                valuedisplay: 1,
                valuecolor: 1,
                valuebackgroundColor: 1,
                valuebackground: 1,
                valuewidth: 1,
                valueheight: 1,
                valuefloat: 1
            }[e]) {
                dom.style[e] = value;
            }
            else if (e === "dataset" && typeof value === "object") {
                for (const k of Object.keys(value)) {
                    dom.dataset[k] = value[k];
                };
            }
            else if (value != null) {
                dom.setAttribute(e, value);
            };
        };
    })();

    (_ => {
        if (childrenValue == null) {
            return;
        };

        const is_object = typeof childrenValue === "object";
        const is_array = Array.isArray(childrenValue);

        if (is_array) {
            for (let e of childrenValue) {
                const is_string = typeof e === "string";
                const is_number = typeof e === "number";
                const is_element = e instanceof Element;

                if (is_string || is_number) {
                    if (isTemp) {
                        dom.appendChild(document.createTextNode(e))
                    }
                    else {
                        dom.innerHTML += e;
                    }
                }
                else if (is_element) {
                    dom.appendChild(e);
                };
            };
            return;
        }
        else if (is_object) {
            return;
        };

        const value = childrenValue;
        const is_img = (cssTag === "img");
        const is_source = (cssTag === "source");
        const is_input = (cssTag === "input");
        const is_textarea = (cssTag === "textarea");

        if (is_img || is_source) {
            dom[_src] = value;
        }
        else if (is_textarea || is_input) {
            dom.value = value
        }
        else if (isTemp) {
            dom.appendChild(document.createTextNode(childrenValue))
        }
        else {
            dom.innerHTML = value;
        };
    })();

    return dom;
};