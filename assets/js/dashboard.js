$(document).ready(function() {
    // Load default tab
    loadTab('overview');

    // Tab click event
    $('.list-group-item').click(function(e) {
        e.preventDefault();
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).data('tab');
        loadTab(tab);
    });

    function loadTab(tab) {
        $.ajax({
            url: './ajax/' + tab + '.php',
            type: 'GET',
            success: function(data) {
                $('#tab-content').html(data);
            },
            error: function() {
                $('#tab-content').html('<p>Lỗi khi tải nội dung. Vui lòng thử lại.</p>');
            }
        });
    }
});