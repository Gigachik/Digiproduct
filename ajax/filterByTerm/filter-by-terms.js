jQuery(document).ready(function ($) {
    const selectedTerms = [];
    let currentPage = 1;
    let postsPerPage = 5;
    let totalPosts = 0;
    var nonce = ajax_params_filter_by_terms.ajax_nonce;

    function doAjaxRequest(props) {
        $.ajax({
            url: ajax_params_filter_by_terms.ajax_url,
            type: "post",
            data: {
                action: "filter_by_terms",
                terms: selectedTerms,
                nonce: nonce,
                paged: currentPage,
                posts_per_page: postsPerPage,
            },
            success: function (response) {
                totalPosts = response.data.total_posts;

                if (props === "filtered") {
                    $(".news_inner").html(response.data.content);
                } else if (props === "load") {
                    $(".news_inner").append(response.data.content);
                }

                if ($(".news_item").length >= totalPosts) {
                    $("#load-more").hide();
                } else {
                    $("#load-more").show();
                }
            },
            error: function (error) {
                console.error("AJAX Error:", error);
            },
        });
    }

    $(".news_filter-list li").on("click", function (e) {
        e.preventDefault();
        $this = $(this);
        $filterBtnPressed = "filtered";

        var term = $(this).data("term");

        const index = selectedTerms.indexOf(term);
        if (index === -1) {
            selectedTerms.push(term);
        } else {
            selectedTerms.splice(index, 1);
        }

        currentPage = 1;

        doAjaxRequest($filterBtnPressed);
        $this.toggleClass("active");
    });

    $("#load-more").on("click", function (e) {
        e.preventDefault();
        $loadMorePressed = "load";

        currentPage++;

        doAjaxRequest($loadMorePressed);
    });
});
