jQuery(document).ready(function () {
    jQuery(document).foundation();
    getContributors();
});

var contributors;
function getContributors() {
    jQuery.ajax({
        url: "https://api.github.com/repos/viniciusbarros/my-team-tree/contributors",
        context: document.body
    }).done(function (data) {
        contributors = data;
        while (contributor = data.pop()){
            console.log(contributor.url);
            jQuery('#contributors').append('<div class="column"><a target="_blank" href="' + contributor.html_url + '"><img class="thumbnail" src="' + contributor.avatar_url + '" alt="' + contributor.login + '" title="' + contributor.login + '"></div>');
        }
    });
}
