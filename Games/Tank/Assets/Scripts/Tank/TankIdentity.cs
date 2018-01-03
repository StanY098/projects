using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Networking;

public class TankIdentity : NetworkBehaviour {

    [SyncVar]
    public int ID;
    
    public void setIdentity(int newID)
    {
        ID = newID;
    }
}
