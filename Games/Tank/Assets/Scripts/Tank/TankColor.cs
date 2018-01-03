using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Networking;

public class TankColor : NetworkBehaviour {

    [SyncVar]
    public Color color;
    MeshRenderer[] rends;

	// Use this for initialization
	void Start () {
        rends = GetComponentsInChildren<MeshRenderer>();
        for(int i = 0; i < rends.Length; i++ )
        {
            rends[i].material.color = color;
        }
	}
	
	// Update is called once per frame
	void Update () {
		
	}
}
