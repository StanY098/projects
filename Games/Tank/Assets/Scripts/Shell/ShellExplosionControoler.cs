using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Networking;

public class ShellExplosionControoler : NetworkBehaviour {

    float MaxLive = 2f;
    float count;
	// Use this for initialization
	void Start () {
        count = 0;
	}
	
    [ServerCallback]
	// Update is called once per frame
	void Update () {
        count += Time.deltaTime;
        if(count > MaxLive)
        {
            NetworkServer.Destroy(gameObject);
        }
	}
}
