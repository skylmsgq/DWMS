package com.geomobile.rc663;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Intent;

public class ErrorParser {
	public static void parse(Scan4 activity, String value) {
		JSONObject jObject;
		try {
			jObject = new JSONObject(value);
			String errmsg = "出现错误\n"; 
				errmsg += ((JSONObject)(jObject.get("error"))).getString("code");
				try {
					errmsg += ": " + ((JSONObject)(jObject.get("error"))).getString("des");
				} catch (JSONException e) {
					activity.alertMessage(e.toString());
				}
			activity.alertMessage(errmsg);
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			if(value.contains("error")) {
				activity.alertMessage("未知错误" + value);
			} else {
				try{
				jObject = new JSONObject(value);
				activity.short_sn=activity.sn;
				if (jObject.has("addway"))
					{activity.sn+="包装类型: "+jObject.getString("addway")+"\n";
					activity.short_sn+="包装类型: "+jObject.getString("addway")+"\n";
					if (jObject.getString("addway").equals("桶装"))
						{activity.sn+="重量: "+jObject.getString("total")+"公斤\n";
						activity.short_sn+="重量: "+jObject.getString("total")+"公斤\n";
						}
					else if (jObject.getString("addway").equals("袋装"))
						{
							activity.short_sn+="数量: "+jObject.getString("total")+"个\n";
							activity.sn+="数量: "+jObject.getString("total")+"个\n";
						}
					if (jObject.has("wname"))
						{activity.sn+="废物类型: "+jObject.getString("wname")+"\n";
						activity.short_sn+="废物类型: "+jObject.getString("wname")+"\n";}	
					}
				activity.short_sn+="运输许可: ";
				if (jObject.has("manifest_status"))
				{
					if (jObject.getString("manifest_status").equals("11"))
						activity.short_sn+="可以运输\n ";
					else
						activity.short_sn+="不可运输\n ";
				}
				else
					activity.short_sn+="不可运输\n ";
//				}
				if (jObject.getString("hasrecord").equals("0"))
					activity.sn+="无备案信息\n";
				else
				{
					
					if (jObject.has("pname"))
						activity.sn+="生产单位: "+jObject.getString("pname")+"\n";
					if (jObject.has("tname"))
						activity.sn+="运输单位: "+jObject.getString("tname")+"\n";
					if (jObject.has("rname"))
						activity.sn+="处置单位: "+jObject.getString("rname")+"\n";
				}	
				if (jObject.has("hasmanifest"))
				{if (jObject.getString("hasmanifest").equals("0"))
					activity.sn+="无联单信息\n";
				else
				{
					if (jObject.has("driver"))
						activity.sn+="运输人: "+jObject.getString("driver")+"\n";
					if (jObject.has("driver_id"))
						activity.sn+="运输人编号: "+jObject.getString("driver_id")+"\n";
					if (jObject.has("carnum"))
						activity.sn+="车牌号: "+jObject.getString("carnum")+"\n";
				}
				}
				if (jObject.has("tstatus"))
					activity.sn+="备案状态: "+jObject.getString("tstatus")+"\n";
					if (jObject.has("rstatus"))
					activity.sn+="运输状态: "+jObject.getString("rstatus")+"\n";
					activity.swh=true;
					activity.sn="RFID: "+activity.sn;
				}
				catch(JSONException e1)
				{
					e.printStackTrace();
					activity.alertMessage(e1.toString() );
				}
			}
		}
	}
}
