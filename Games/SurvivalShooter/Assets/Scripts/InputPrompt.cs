using System.Collections;
using System.Collections.Generic;
using UnityEngine;


public class InputPrompt : MonoBehaviour {
    public static string textFieldString;
    static string instruction;
    GUIStyle style;
    void Start()
    {
        textFieldString = "";
    }
    void OnGUI()
    {
        GUI.skin.label.fontSize = 40;
        textFieldString = GUI.TextField(new Rect(620,250,300,20), textFieldString, 50);
        PlayerPrefs.SetString("PlayerName", textFieldString);
    }
}
