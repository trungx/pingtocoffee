function Search(form, input, resultsContainer, showResults) {
    const search = {
        form: form,
        input: input,
        resultsContainer: resultsContainer,
        timeoutId: undefined
    };

    search.init = function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        bindEvents();
    };

    search.init();

    function showNoResults(message) {
        let html = `<li class="header-search-result pa2 bg-white relative">${message}</li>`;
        appendResults(html);
    }

    function appendResults(html) {
        search.resultsContainer.empty();
        search.resultsContainer.append(html);
    }

    function parseResults(data) {
        let results = [];
        data.forEach(function (user) {
            let person = {};

            person.id = user.id;
            person.url = `/${user.username}`;
            person.name = user.first_name + ' ' + user.last_name;
            person.avatar = user.avatar;
            person.initials = user.initials;
            person.default_avatar_color = user.default_avatar_color;

            results.push(person);
        });

        return results;
    }

    function getInputValue() {
        let value = search.input.eq(0).val();
        if (value === '') {
            value = search.input.eq(1).val();
        }
        return value;
    }

    function searchInContact() {
        const needle = getInputValue();

        if (needle === '' || needle === undefined) {
            return;
        }

        $.post({
            url: '/users/search',
            data: {
                needle: needle
            }
        }).done(function (data) {
            if (data.noResults !== undefined) {
                showNoResults(data.noResults);
                return;
            }
            const results = parseResults(data);
            showResults(results, search);
        });
    }

    function bindEvents() {
        search.input.on('keyup', function () {
            if (search.timeoutId !== undefined) {
                window.clearTimeout(search.timeoutId);
            }
            // Search delay time from last press on keyboard
            search.timeoutId = window.setTimeout(searchInContact, 400);
        });

        // Search by submit form
        search.form.submit(function (e) {
            e.preventDefault();

            if (search.timeoutId !== null) {
                window.clearTimeout(search.timeoutId);
            }
            searchInContact();
            search.input.val('');
        });

        // Hide search result when focusout
        search.input.on('focusout blur', function () {
            window.setTimeout(function () {
                $('.header-search-result').css('display', 'none');
            }, 200);
        });

        // Show search result when focusin
        search.input.on('focusin', function () {
            if ($(this).val().length === 0) {
                $('.header-search-result').remove();
            } else {
                $('.header-search-result').css('display', 'block');
            }
        });
    }
}

const HeaderSearch = Search(
    $('.header-search > form'),
    $('.header-search-input'),
    $('.header-search-results'),
    function (results, search) {
        let html = '';
        results.forEach(function (result) {
            html += `<li class="header-search-result pa2 relative bg-white">`;
            if (result.avatar === null) {
                html += `<div class="default-avatar mr-2" style="background-color: ${result.default_avatar_color}; width:40px; height:40px; font-size:14px; padding-top:8px;">${result.initials}</div>`;
            } else {
                html += `<img src="${result.avatar}" alt="Avatar" class="mr-2" width="40">`;
            }

            html += `<a href="${result.url}" class="search-item-name">${result.name}<span /></a></li>`;
        });
        search.resultsContainer.empty();
        search.resultsContainer.append(html);
    }
);
