<?php if (!defined('THINK_PATH')) exit();?><div class="panel panel-primary">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <table id="table-container">
        </table>
    </div>
</div>

<script type="text/javascript">
function setTable() {
    //console.log(production_unit_name);
    var tableData = new Array();
    for (var idx in record_json) {
        var itemData = new Array();
        itemData[0] = "" + record_json[idx].waste_id;
        itemData[1] = "" + record_json[idx].add_date_time;
        switch (record_json[idx].rfid_status) {
            case '0':
                itemData[2] = "<span class='label label-primary'>绑定废物</span>";
                break;
            case '1':
                itemData[2] = "<span class='label label-warning'>危废出库</span>";
                break;
            case '2':
                itemData[2] = "<span class='label label-success'>危废接受</span>";
                break;
            case '3':
                itemData[2] = "<span class='label label-info'>危废在库</span>";
                break;
            default:
                itemData[2] = "<span class='label label-danger'>状态错误</span>";
                break;
        }
        switch (record_json[idx].add_method) {
            case '0':
                itemData[3] = "<span class='label label-primary'>重量</span>";
                itemData[5] = "公斤";
                break;
            case '1':
                itemData[3] = "<span class='label label-info'>数量</span>";
                itemData[5] = "个";
                break;
            default:
                itemData[3] = "<span class='label label-danger'>状态错误</span>";
                itemData[5] = "状态错误";
                break;
        }
        itemData[4] = "" + record_json[idx].waste_total;

        itemData[6] = "" + production_unit_name[idx];
        //  console.log(production_unit_name[idx]);
        tableData.push(itemData);
    }

    $('#table-container').dataTable({
        "aaData": tableData,
        "aoColumns": [{
            "sTitle": "废物编号"
        }, {
            "sTitle": "入库时间"
        }, {
            "sTitle": "废物状态"
        }, {
            "sTitle": "增加类型"
        }, {
            "sTitle": "废物总量"
        }, {
            "sTitle": "单位"
        }, {
            "sTitle": "生产企业"
        }],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": true,
        "bStateSave": true,
        "sPaginationType": "full_numbers",

        "oLanguage": {
            "sLengthMenu": "每页显示 _MENU_ 条记录",
            "sZeroRecords": "抱歉， 没有找到",
            "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
            "sInfoEmpty": "没有数据",
            "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
            "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "前一页",
                "sNext": "后一页",
                "sLast": "尾页"
            },
            "sZeroRecords": "没有检索到数据"
        }
    });
}
setTable();

// function fetch_model_page(ajaxURL) {
//     $('#myModal').modal("show");
//     $("#model-content").html('<center style="margin-top:20px"><h4>努力地加载中...</h4><div class="progress progress-striped active" style="width: 50%"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></center>');

//     $.ajax({
//         type: "get",
//         url: ajaxURL,
//         dataType: "json",
//         success: function(data) {
//          //alert(data);
//             $("#model-content").html(data);

//         },
//         error: function(XMLHttpRequest, textStatus, errorThrown) {
//             console.log("Error:Ajax_Content_Load" + errorThrown);
//             console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
//             console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
//             console.log("textStatus:" + textStatus);
//         }
//     });

// }
</script>