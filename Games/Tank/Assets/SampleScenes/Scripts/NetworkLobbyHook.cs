using UnityEngine;
using Prototype.NetworkLobby;
using System.Collections;
using UnityEngine.Networking;
using System.Collections.Generic;

public class NetworkLobbyHook : LobbyHook 
{
    int ID = 1;
    public static int totalPlayerCount = 0;
    public static List<GameObject> clientDeathCount = new List<GameObject>();
    public override void OnLobbyServerSceneLoadedForPlayer(NetworkManager manager, GameObject lobbyPlayer, GameObject gamePlayer)
    {
        LobbyPlayer lobby = lobbyPlayer.GetComponent<LobbyPlayer>();
        TankColor tank = gamePlayer.GetComponent<TankColor>();
        ClampName playerName = gamePlayer.GetComponentInChildren<ClampName>();
        TankIdentity playerID = gamePlayer.GetComponent<TankIdentity>();
        tank.color = lobby.playerColor;
        playerName.nickName = lobby.playerName;
        playerName.color = lobby.playerColor;
        totalPlayerCount = ID;
        playerID.setIdentity(ID++);
    }
}
