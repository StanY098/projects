using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class BoardController : MonoBehaviour {

    int[] highScores;
    string[] names;
    static int newScore;
    static string newName;
    Text text;
    int score1;
    int score2;
    int score3;
    string name1;
    string name2;
    string name3;
    // Use this for initialization
    void Awake () {
        text = GetComponent<Text>();
        /*PlayerPrefs.DeleteKey("Score1");
        PlayerPrefs.DeleteKey("Score2");
        PlayerPrefs.DeleteKey("Score3");
        PlayerPrefs.DeleteKey("Name1");
        PlayerPrefs.DeleteKey("Name2");
        PlayerPrefs.DeleteKey("Name3");*/
        score1 = 500;
        score2 = 300;
        score3 = 200;
        name1 = "Stanley";
        name2 = "Kenneth";
        name3 = "Michaela";
        if (PlayerPrefs.HasKey("Score1") && PlayerPrefs.HasKey("Score2") && PlayerPrefs.HasKey("Score3") && PlayerPrefs.HasKey("Name1") && PlayerPrefs.HasKey("Name2") && PlayerPrefs.HasKey("Name3"))
        {
            score1 = PlayerPrefs.GetInt("Score1");
            score2 = PlayerPrefs.GetInt("Score2");
            score3 = PlayerPrefs.GetInt("Score3");
            name1 = PlayerPrefs.GetString("Name1");
            name2 = PlayerPrefs.GetString("Name2");
            name3 = PlayerPrefs.GetString("Name3");
        }
        /*else
        {
            score1 = 500;
            score2 = 300;
            score3 = 200;
            name1 = "Stanley";
            name2 = "Kenneth";
            name3 = "Michaela";
        }*/
        highScores = new int[3] { score1, score2, score3 };
        names = new string[3] { name1, name2, name3 };
    }
	
	// Update is called once per frame
	void Update () {
        if (PlayerPrefs.HasKey("PlayerName")) {
            newScore = PlayerPrefs.GetInt("HiScore");
            newName = PlayerPrefs.GetString("PlayerName");
            int counter = 0;
            int index = 0;
            foreach(int score in highScores)
            {
                if(score < newScore)
                {
                    index = counter;
                    break;
                }
                counter++;
            }
            if(index >= 0 && index <= 2)
            {
                swapPos(index);
            }
            saveData();
            PlayerPrefs.DeleteKey("PlayerName");
        }
        showBoard(highScores, names);
    }
    void swapPos(int index)
    {
        for(int counter=2;counter >= index; counter--)
        {
            if (index == counter)
            {
                highScores[counter] = newScore;
                names[counter] = newName;
            }
            else
            {
                highScores[counter] = highScores[counter - 1];
                names[counter] = names[counter - 1];
            }
        }
    }
    void showBoard(int[] highScores, string[] names)
    {
        string space = " ";
        int multipler = 48;
        int refiner;
        text.text = "";
        for (int i = 0; i < highScores.Length; i++)
        {
            refiner = multipler - names[i].Length - highScores[i].ToString().Length;
            space = new string(' ', refiner);
            text.text += (i+1) + ". " + names[i] + space + highScores[i];
            if(i != highScores.Length - 1)
            {
                text.text += "\n";
            }
        }
    }
    void saveData()
    {
        PlayerPrefs.SetInt("Score1", highScores[0]);
        PlayerPrefs.SetInt("Score2", highScores[1]);
        PlayerPrefs.SetInt("Score3", highScores[2]);
        PlayerPrefs.SetString("Name1", names[0]);
        PlayerPrefs.SetString("Name2", names[1]);
        PlayerPrefs.SetString("Name3", names[2]);
    }
}
