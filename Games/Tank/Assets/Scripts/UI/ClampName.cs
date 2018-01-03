using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;

public class ClampName : NetworkBehaviour {

    [SyncVar]
    public string nickName = "Player";
    [SyncVar]
    public Color color;
    public Text NameLabel;

    void Start()
    {
        NameLabel.text = "" + nickName;
        NameLabel.color = color;
    }
}
