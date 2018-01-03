using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using UnityEngine.SceneManagement;


public class EnemyHealth : MonoBehaviour
{
    public int startingHealth = 100;
    public int currentHealth;
    public Slider healthSlider;
    public float sinkSpeed = 2.5f;
    public int scoreValue = 10;
    public AudioClip deathClip;
    float timer = 5f;


    Animator anim;
    AudioSource enemyAudio;
    ParticleSystem hitParticles;
    CapsuleCollider capsuleCollider;
    bool isDead;
    bool isSinking;
    GameObject save;
    int specialDemage;

    void Awake ()
    {
        anim = GetComponent <Animator> ();
        enemyAudio = GetComponent <AudioSource> ();
        hitParticles = GetComponentInChildren <ParticleSystem> ();
        capsuleCollider = GetComponent <CapsuleCollider> ();
        currentHealth = startingHealth;
        specialDemage = 10;
    }


    void Update()
    {
        if (isSinking)
        {
            transform.Translate(-Vector3.up * sinkSpeed * Time.deltaTime);
            timer -= 1f * Time.deltaTime;
            if (timer <= 0)
            {
                if (this.gameObject == GameObject.FindGameObjectWithTag("Boss"))
                {
                    int y = SceneManager.GetActiveScene().buildIndex;
                    DontDestroyOnLoad(GameObject.FindGameObjectWithTag("BackGroundMusic"));
                    SceneManager.LoadScene(y + 1);
                }
                Destroy(gameObject, 2f);
            }
        }
        if (CameraSelector.activate)
        {
            TakeDamage(specialDemage);
        }
    }

    public void TakeDamage (int amount, Vector3 hitPoint)
    {
        if(isDead)
            return;

        enemyAudio.Play ();

        currentHealth -= amount;

        if(this.gameObject == GameObject.FindWithTag("Boss"))
        {
            healthSlider.value = currentHealth;
        }
        hitParticles.transform.position = hitPoint;
        hitParticles.Play();

        if(currentHealth <= 0)
        {
            Death ();
        }
    }

    public void TakeDamage(int amount)
    {
        if (isDead)
            return;

        enemyAudio.Play();

        currentHealth -= amount;

        if (this.gameObject == GameObject.FindWithTag("Boss"))
        {
            healthSlider.value = currentHealth;
        }

        if (currentHealth <= 0)
        {
            Death();
        }
    }


    void Death()
    {
        isDead = true;

        capsuleCollider.isTrigger = true;

        anim.SetTrigger("Dead");

        enemyAudio.clip = deathClip;
        enemyAudio.Play();
        if(this.gameObject == GameObject.FindWithTag("Boss") && SceneManager.GetActiveScene().buildIndex != 2)
        {
            GameObject.FindWithTag("Boss").transform.Rotate(45, 0, 0);
            StartSinking();
        }
    }
    public void StartSinking ()
    {
        GetComponent <UnityEngine.AI.NavMeshAgent> ().enabled = false;
        GetComponent <Rigidbody> ().isKinematic = true;
        isSinking = true;
        ScoreManager.score += scoreValue;
    }
}
