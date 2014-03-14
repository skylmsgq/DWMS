package com.geomobile.rc663;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Intent;

public class ErrorParser {
	public static void parse(Scan4 activity, String value) {
		JSONObject jObject;
		JSONObject detailjson;
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
				activity.short_sn=activity.sn+"%";
				detailjson=new JSONObject();
				detailjson.put("rfid", activity.sn);
				if (jObject.has("addway"))
					{
					//activity.sn+="包装类型:\t"+jObject.getString("addway")+"公斤\n";
					detailjson.put("wrap", jObject.getString("addway"));
					activity.short_sn+=jObject.getString("addway")+"%";
					if (jObject.getString("addway").equals("桶装"))
						{
						//activity.sn+="重量:\t"+jObject.getString("total")+"公斤\n";
						detailjson.put("num", jObject.getString("total")+"公斤");
						activity.short_sn+=jObject.getString("total")+"公斤%";
						}
					else if (jObject.getString("addway").equals("袋装"))
						{
							activity.short_sn+=jObject.getString("total")+"个%";
							//activity.sn+="数量:\t"+jObject.getString("total")+"个\n";
							detailjson.put("num", jObject.getString("total")+"个");
						}
					if (jObject.has("waste_category_code"))
					{
						//activity.sn+="废物类型代码:\t"+jObject.getString("waste_category_code")+"\n";
						detailjson.put("waste_code", jObject.getString("waste_category_code"));
						activity.short_sn+=jObject.getString("waste_category_code")+"%";}
					if (jObject.has("wname"))
						{
						//activity.sn+="废物类型:\t"+jObject.getString("wname")+"\n";
						detailjson.put("waste_type", jObject.getString("wname"));
						activity.short_sn+=jObject.getString("wname")+"%";}
					}
				if (jObject.has("manifest_status"))
				{
					if (jObject.getString("manifest_status").equals("11"))
						{
							if (jObject.getString("rstatus").equals("接受"))
							activity.short_sn+="不可运输%";
							else
								activity.short_sn+="可以运输%";
						 
						}
					else
						activity.short_sn+="不可运输%";
				}
				else
					activity.short_sn+="不可运输%";
//				}
				if (!jObject.getString("hasrecord").equals("0"))
				{
					
					if (jObject.has("pname"))
						//activity.sn+="生产单位:\t"+jObject.getString("pname")+"\n";
						detailjson.put("production", jObject.getString("pname"));
					if (jObject.has("tname"))
						//activity.sn+="运输单位:\t"+jObject.getString("tname")+"\n";
						detailjson.put("transport", jObject.getString("tname"));
					if (jObject.has("rname"))
						//activity.sn+="处置单位:\t"+jObject.getString("rname")+"\n";
						detailjson.put("reception", jObject.getString("rname"));
				}	
				if (jObject.has("hasmanifest"))
				{if (!jObject.getString("hasmanifest").equals("0"))
				{
					if (jObject.has("driver"))
						detailjson.put("driver", jObject.getString("driver"));
						//activity.sn+="运输人:\t"+jObject.getString("driver")+"\n";
					if (jObject.has("driver_id"))
//						activity.sn+="运输人编号:\t"+jObject.getString("driver_id")+"\n";
						detailjson.put("driver_code", jObject.getString("driver_id"));
					if (jObject.has("carnum"))
//						activity.sn+="车牌号:\t"+jObject.getString("carnum")+"\n";
						detailjson.put("car_code", jObject.getString("carnum"));
				}
				}
				if (jObject.has("tstatus"))
//					activity.sn+="备案状态:\t"+jObject.getString("tstatus")+"\n";
					detailjson.put("t_status", jObject.getString("tstatus"));
				if (jObject.has("rstatus"))
//					activity.sn+="运输状态:\t"+jObject.getString("rstatus")+"\n";
					detailjson.put("r_status", jObject.getString("rstatus"));
				activity.swh=true;
//					activity.sn="RFID:\t"+activity.sn;
				activity.sn=detailjson.toString();
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
