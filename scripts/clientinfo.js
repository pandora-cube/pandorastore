function getOSName() {
	var userAgent = navigator.userAgent;
	if(userAgent.indexOf("Windows NT 10.0") != -1) return "Windows 10";
	else if(userAgent.indexOf("Windows NT 6.2") != -1) return "Windows 8";
	else if(userAgent.indexOf("Windows NT 6.1") != -1) return "Windows 7";
	else if(userAgent.indexOf("Windows NT 6.0") != -1) return "Windows Vista";
	else if(userAgent.indexOf("Windows NT 5.1") != -1) return "Windows XP";
	else if(userAgent.indexOf("Windows NT 5.0") != -1) return "Windows 2000";
	else if(userAgent.indexOf("Mac") != -1) return "Mac/iOS";
	else if(userAgent.indexOf("X11") != -1) return "UNIX";
	else if(userAgent.indexOf("Android") != -1) return "Android";
	else if(userAgent.indexOf("Linux") != -1) return "Linux";
	else return "Unknown";
}
