//Add extra data for ajax POST upload with file
var fileUpload = $("#fileupload-file");
fileUpload.fileinput({
    uploadExtraData: function (previewId, index) {
        var obj = {};
        obj['text'] = $('#fileupload-text').val();

        return obj;
    },
    uploadUrl: '/upload',
    previewFileIcon: '<i class="fa fa-file"></i>',
    allowedPreviewTypes: ['image', 'text'],
    previewFileIconSettings: {
        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
        'xls': '<i class="fa fa-file-excel-o text-success"></i>',
        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'docx': '<i class="fa fa-file-word-o text-primary"></i>',
        'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
        'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
    },
    allowedFileExtensions: ['jpg', 'gif', 'png', 'doc', 'xls', 'xlsx', 'docx', 'ppt', 'pptx', 'pdf']
});

// Clear form on success
fileUpload.on('fileuploaded', function (event, data, previewId, index) {
    fileUpload.fileinput('clear');
    $('#fileupload-text').val('');
});